<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');
        $this->withoutMiddleware(); // Disables CSRF middleware

        // Create an admin user with the 'admin' role
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        $this->user = User::factory()->create();
    }

    /** @test */
    public function admin_can_create_category()
    {
        $this->actingAs($this->admin);
        $this->withoutMiddleware();
        $response = $this->postJson('/create-category', [
            'name' => 'Electronics',
            'display_name' => 'Various electronic items',
        ]);

        $response->assertStatus(200)
            ->assertExactJson(['Category successfully created']);

        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics',
            'display_name' => 'Various electronic items',
        ]);
    }

    /** @test */
    public function non_admin_user_cannot_create_category()
    {
        $this->actingAs($this->user);
        $this->withoutMiddleware();

        $response = $this->postJson('/create-category', [
            'name' => 'Books',
            'display_name' => 'Various books',
        ]);

        $response->assertStatus(403); // Forbidden

        $this->assertDatabaseMissing('categories', [
            'name' => 'Books',
        ]);
    }

    /** @test */
    public function admin_can_update_category()
    {
        $this->actingAs($this->admin);

        // Create a category to update
        $category = Category::factory()->create([
            'name' => 'Clothing',
            'display_name' => 'Men and women clothing',
        ]);

        $response = $this->postJson('/update-category', [
            'id' => $category->id,
            'name' => 'Updated Clothing',
            'display_name' => 'Updated description',
        ]);

        $response->assertStatus(200)
            ->assertExactJson(['Category successfully updated.']);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Clothing',
            'display_name' => 'Updated description',
        ]);
    }

    /** @test */
    public function admin_can_delete_category()
    {
        $this->actingAs($this->admin);

        // Create a category to delete
        $category = Category::factory()->create();

        $response = $this->postJson('/delete-category', [
            'cat_id' => $category->id,
        ]);

        $response->assertStatus(200)
            ->assertExactJson(['Category successfully deleted.']);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    /** @test */
    public function non_admin_user_cannot_delete_category()
    {
        $this->actingAs($this->user);

        $category = Category::factory()->create();

        $response = $this->postJson('/delete-category', [
            'cat_id' => $category->id,
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }

    /** @test */
    public function admin_can_get_category_table_data()
    {
        $this->actingAs($this->admin);

        // Create a few categories
        Category::factory()->count(5)->create();

        $response = $this->getJson(route('category-data'));

        $response->assertStatus(200);
        $this->assertCount(5, $response->json()['data']);
    }
}
