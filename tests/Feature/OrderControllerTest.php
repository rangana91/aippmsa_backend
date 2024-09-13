<?php

namespace Tests\Unit;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $orderRepositoryMock;
    protected $user;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');

        // Create a mock of the OrderRepository
        $this->orderRepositoryMock = $this->createMock(OrderRepository::class);

        // Create a user and an item for testing
        $this->user = User::factory()->create();
        $this->item = Item::factory()->create();
    }

    /** @test */
//    public function it_can_store_an_order()
//    {
//        // Authenticate the test user
//        $user = User::factory()->create()->assignRole('customer');
//        $token = $user->createToken('auth_token')->plainTextToken;
////        $this->actingAs($user);
//
//        // Mock request data
//        $requestData = [
//            'item_id' => $this->item->id,
//            'quantity' => 2,
//            'shipping_address' => '123 Street Name',
//        ];
//
//        // Mock the store method in the OrderRepository
//        $this->orderRepositoryMock
//            ->expects($this->once())
//            ->method('store')
//            ->willReturn(response()->json(['message' => 'Order created successfully'], 200));
//
//        // Perform the HTTP request to the store route
//        $response = $this->withHeaders([
//            'Authorization' => 'Bearer ' . $token,
//            'Accept' => 'application/json',
//            'Content-type' => 'application/json'
//        ])->postJson('/api/place-order', $requestData);
//
//        // Assert that the response status is 200
//        $response->assertStatus(200);
//
//        // Assert that the JSON response contains the message
//        $response->assertJson([
//            'message' => 'Order created successfully'
//        ]);
//    }

    /** @test */
//    public function it_can_get_user_orders()
//    {
//        // Authenticate the test user
//        $this->actingAs($this->user);
//
//        // Mock some orders
//        $orders = Order::factory()->count(2)->create(['user_id' => $this->user->id]);
//
//        // Mock the getUserOrders method in the OrderRepository
//        $this->orderRepositoryMock
//            ->expects($this->once())
//            ->method('getUserOrders')
//            ->willReturn($orders);
//
//        // Perform the HTTP request to the user orders route
//        $response = $this->getJson('/user/orders');
//
//        // Assert that the response status is 200
//        $response->assertStatus(200);
//
//        // Assert that the response contains the orders
//        $response->assertJsonCount(2); // Make sure there are 2 orders returned
//    }

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
