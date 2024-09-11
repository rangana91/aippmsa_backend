<?php

namespace Tests\Feature;

use App\Http\Controllers\ItemsController;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use App\repositories\ItemRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ItemsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;
    protected $itemRepositoryMock;
    protected $itemsController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');
        $this->withoutMiddleware(); // Disables CSRF middleware
        // Create a regular user and admin user
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        // Mock ItemRepository
        $this->itemRepositoryMock = $this->createMock(ItemRepository::class);
        $this->app->instance(ItemRepository::class, $this->itemRepositoryMock);
    }

    /** @test */
    public function admin_can_create_item()
    {
        // Set up user as admin
        $this->actingAs($this->admin);

        // Mock repository's create method
        $this->itemRepositoryMock->expects($this->once())
            ->method('create')
            ->willReturn(new JsonResponse(['Item successfully added.'], 200));

        $response = $this->postJson('/add-item', [
            'name' => 'Test Item',
            'type' => 'shirt',
            'description' => 'Test description',
            'price' => 100,
            'category_id' => Category::factory()->create()->id,
            'size' => ['l'],
            'color' => ['white'],
            'quantity' => [10],

        ]);

        $response->assertStatus(200)
            ->assertExactJson(['Item successfully added.']);
    }

    /** @test */
    public function non_admin_cannot_create_item()
    {
        // Act as a non-admin user
        $this->actingAs($this->user);

        $response = $this->postJson('/add-item', [
            'name' => 'Test Item',
            'type' => 'shirt',
            'description' => 'Test description',
            'price' => 100,
            'category_id' => Category::factory()->create()->id,
            'size' => ['l'],
            'color' => ['white'],
            'quantity' => [10],
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_item()
    {
        // Act as an admin
        $this->actingAs($this->admin);

        // Create an item
        $item = Item::factory()->create(['name' => 'Old Item Name']);

        // Mock repository's update method
        $this->itemRepositoryMock->expects($this->once())
            ->method('update')
            ->willReturn(new JsonResponse(['message' => 'Item successfully updated.'], 200));

        // Send request to update item
        $response = $this->postJson('/update-item', [
            'id' => $item->id,
            'name' => 'Updated Item Name',
            'category_id' => Category::factory()->create()->id,
            'price' => 100.00,
            'variants' => [['color' => 'white', 'quantity' => 10, 'size' => 'l']]
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item successfully updated.']);
    }

    /** @test */
    public function admin_can_delete_item()
    {
        // Act as an admin
        $this->actingAs($this->admin);

        // Create an item
        $item = Item::factory()->create();

        // Mock repository's delete method
        $this->itemRepositoryMock->expects($this->once())
            ->method('delete')
            ->willReturn(new JsonResponse(['Item successfully deleted.'], 200));

        // Send delete request
        $response = $this->postJson('/delete-item', ['item_id' => $item->id]);

        $response->assertStatus(200)
            ->assertExactJson(['Item successfully deleted.']);
    }

    /** @test */
    public function admin_can_fetch_item_table_data()
    {
        // Act as an admin
        $this->actingAs($this->admin);

        // Mock item data
        $items = Item::factory()->count(5)->make();

        $response = $this->getJson('/api/items');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_cannot_delete_item()
    {
        // Act as a non-admin user
        $this->actingAs($this->user);

        $item = Item::factory()->create();

        $response = $this->postJson('/delete-item', ['item_id' => $item->id]);

        $response->assertStatus(403);
    }

}
