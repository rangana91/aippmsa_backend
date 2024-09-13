<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\User;
use App\repositories\ItemRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ItemRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $itemRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        // Mock the ItemRepository
        $this->itemRepository = new ItemRepository();
    }

    /** @test */
    public function it_can_get_items_by_type()
    {
        Item::factory()->create(['type' => 'shirt']);
        Item::factory()->create(['type' => 'sandals']);

        // Mock the authenticated user
        $this->actingAs($this->user);

        $response = $this->itemRepository->getItemsByType('shirt');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = json_decode($response->getContent(), true);
        $this->assertCount(1, $data['data']);  // Should return 1 vinyl item
    }

    /** @test */
    public function it_can_create_an_item_with_variants()
    {
        $this->actingAs($this->user);
        $category = Category::factory()->create();

        // Mock request data
        $request = new \Illuminate\Http\Request([
            'name' => 'Test Item',
            'type' => 'shirt',
            'imageFile' => null,
            'size' => ['L', 'M'],
            'color' => ['red', 'blue'],
            'quantity' => [10, 15],
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        $response = $this->itemRepository->create($request);

        $this->assertDatabaseHas('items', ['name' => 'Test Item']);
        $this->assertDatabaseHas('item_variants', ['size' => 'L', 'color' => 'red']);
        $this->assertDatabaseHas('item_variants', ['size' => 'M', 'color' => 'blue']);
    }

    /** @test */
    public function it_can_update_an_item_and_variants()
    {
        $item = Item::factory()->create(['type' => 'shirt']);

        // Mock the authenticated user
        $this->actingAs($this->user);

        // Mock request data
        $request = new \Illuminate\Http\Request([
            'id' => $item->id,
            'name' => 'Updated Item',
            'imageFile' => null,
            'variants' => [
                ['size' => 'S', 'color' => 'green', 'quantity' => 5],
                ['size' => 'M', 'color' => 'yellow', 'quantity' => 10]
            ]
        ]);

        $response = $this->itemRepository->update($request);

        // Check that the item and variants were updated
        $this->assertDatabaseHas('items', ['name' => 'Updated Item']);
        $this->assertDatabaseHas('item_variants', ['size' => 'S', 'color' => 'green']);
        $this->assertDatabaseHas('item_variants', ['size' => 'M', 'color' => 'yellow']);
    }

    /** @test */
    public function it_can_delete_an_item()
    {
        $item = Item::factory()->create();

        $this->actingAs($this->user);

        // Mock request data
        $request = new \Illuminate\Http\Request([
            'item_id' => $item->id,
        ]);

        $response = $this->itemRepository->delete($request);
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /** @test */
    public function it_can_get_ai_predictions()
    {
        $this->actingAs($this->user);
        $item = Item::factory()->create(['type' => 'shirt']);
        Http::fake([
            '*' => Http::response([
                'top_5_items' => ['shirt', 'blouse']
            ], 200)
        ]);

        $response = $this->itemRepository->getPredictions();

        $this->assertCount(1, $response);
    }
}
