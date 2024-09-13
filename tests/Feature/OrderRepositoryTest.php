<?php

namespace Tests\Unit\Repositories;

use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\Order;
use App\Models\User;
use App\repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $orderRepository;
    protected $user;
    protected $item;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');

        // Create a user to authenticate with
        $this->user = User::factory()->create();
        $this->user->assignRole('customer');

        // Create an item and item variants
        $this->item = Item::factory()->create();
        $this->itemVariant = ItemVariant::factory()->create([
            'item_id' => $this->item->id,
            'size' => 'M',
            'color' => 'red',
            'quantity' => 10
        ]);

        // Mock the OrderRepository
        $this->orderRepository = new OrderRepository();
    }

    /** @test */
    public function it_can_store_an_order()
    {
        // Authenticate the user
        $this->actingAs($this->user);
        $token = $this->user->createToken('auth_token')->plainTextToken;

        $request = new \Illuminate\Http\Request([
            'shipping_address' => '123 Test Street',
            'items' => [
                [
                    'item_id' => $this->item->id,
                    'quantity' => 2,
                    'color' => 'red',
                    'size' => 'M',
                ]
            ],
        ]);
        $request->setUserResolver(function () {
            return $this->user;
        });

        $response = $this->orderRepository->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $responseData = $response->getData();
        $this->assertEquals('Order created successfully.', $responseData->message);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'shipping_address' => '123 Test Street',
            'status' => Order::STATUS_CONFIRMED
        ]);

        $this->assertDatabaseHas('order_items', [
            'item_id' => $this->item->id,
            'quantity' => 2,
            'color' => 'red',
            'size' => 'M',
        ]);

        $this->assertDatabaseHas('item_variants', [
            'item_id' => $this->item->id,
            'size' => 'M',
            'color' => 'red',
            'quantity' => 8,
        ]);
    }

    /** @test */
    public function it_can_get_user_orders()
    {
        $this->actingAs($this->user);

        $order = Order::factory()->create([
            'user_id' => $this->user->id,
            'shipping_address' => '123 Test Street',
            'status' => Order::STATUS_CONFIRMED,
        ]);

        $order->items()->create([
            'item_id' => $this->item->id,
            'quantity' => 1,
            'color' => 'red',
            'size' => 'M',
            'price' => $this->item->price,
        ]);

        $request = new \Illuminate\Http\Request();
        $request->setUserResolver(function () {
            return $this->user;
        });

        $orders = $this->orderRepository->getUserOrders($request);

        $this->assertNotEmpty($orders);

        $this->assertEquals($this->user->id, $orders->first()->user_id);

        $this->assertCount(1, $orders->first()->items);
    }
}
