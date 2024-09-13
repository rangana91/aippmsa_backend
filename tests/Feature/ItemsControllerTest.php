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
        $this->withoutMiddleware();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->itemRepositoryMock = $this->createMock(ItemRepository::class);
        $this->app->instance(ItemRepository::class, $this->itemRepositoryMock);
    }

    /** @test */
    public function admin_can_create_item()
    {
        $this->actingAs($this->admin);

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
        $this->actingAs($this->admin);

        $item = Item::factory()->create(['name' => 'Old Item Name']);

        // Mock repository's update method
        $this->itemRepositoryMock->expects($this->once())
            ->method('update')
            ->willReturn(new JsonResponse(['message' => 'Item successfully updated.'], 200));

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
        $this->actingAs($this->admin);

        $item = Item::factory()->create();

        $this->itemRepositoryMock->expects($this->once())
            ->method('delete')
            ->willReturn(new JsonResponse(['Item successfully deleted.'], 200));

        $response = $this->postJson('/delete-item', ['item_id' => $item->id]);

        $response->assertStatus(200)
            ->assertExactJson(['Item successfully deleted.']);
    }

    /** @test */
    public function admin_can_fetch_item_table_data()
    {
        $this->actingAs($this->admin);

        $items = Item::factory()->count(5)->make();

        $response = $this->getJson('/api/items');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_cannot_delete_item()
    {
        $this->actingAs($this->user);

        $item = Item::factory()->create();

        $response = $this->postJson('/delete-item', ['item_id' => $item->id]);

        $response->assertStatus(403);
    }

}
