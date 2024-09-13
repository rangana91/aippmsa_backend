<?php

namespace Tests\Unit;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');

        // Create a user and an item for testing
        $this->user = User::factory()->create();
        $this->item = Item::factory()->create();
        ItemVariant::factory()->create(['item_id' => $this->item->id, 'color' => 'white', 'size' => 'l']);
    }

    /** @test */
    public function it_can_store_an_order()
    {
        // Authenticate the test user
        $user = User::factory()->create()->assignRole('customer');
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->actingAs($user, 'api');

        // Mock request data
        $requestData = [
            'items' => [['item_id' => $this->item->id,
                'quantity' => 1,
                'price' => '100.00',
                'color' => 'white',
                'size' => 'l',
            ]],
            'quantity' => 2,
            'shipping_address' => '123 Street Name',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ])->postJson('/api/create-order', $requestData);

        $response->assertStatus(200);

        $this->assertEquals('Order created successfully.', json_decode($response->getContent())->message);
    }

    /** @test */
    public function it_can_get_user_orders()
    {
        $user = User::factory()->create()->assignRole('customer');
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->actingAs($user, 'api');

        // Mock some orders
        $orders = Order::factory()->count(2)->create(['user_id' => $user->id]);

        // Perform the HTTP request to the user orders route
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ])->getJson('/api/get-orders');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    /** @test */
    public function it_can_return_order_table_data()
    {
        $this->actingAs($this->user);
        Order::factory()->count(3)->create();
        $response = $this->getJson('/order-data');
        $response->assertStatus(200);
        $this->assertEquals(3, json_decode($response->getContent())->recordsTotal);
    }
}
