<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // This method sets up the test environment and runs migrations
    protected function setUp(): void
    {
        parent::setUp();

        // Run the database migrations using an in-memory SQLite database
        $this->artisan('migrate');
    }

    /** @test */
    public function it_can_get_user_details()
    {
        // Arrange: create a user and log them in
        $user = User::factory()->create();
        Auth::login($user);

        // Act: make a get request to the user details endpoint
        $response = $this->actingAs($user)->getJson('/api/get-user'); // Adjust your route accordingly

        // Assert: check if the correct user is returned
        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ]);
    }

    /** @test */
    public function it_can_update_user_details()
    {
        // Arrange: create a user and log them in
        $user = User::factory()->create();
        Auth::login($user);

        // New data to update
        $updatedData = [
            'first_name' => 'UpdatedFirstName',
            'last_name' => 'UpdatedLastName',
            'email' => 'updatedemail@example.com',
            'gender' => 'Male',
            'date_of_birth' => '1991-11-07',
            'city' => 'Kuliyapitiya',
            'post_code' => '60200'
        ];

        // Act: send a PUT request to update the user
        $response = $this->actingAs($user)->postJson('/api/update-user', $updatedData); // Adjust your route accordingly

        // Assert: check if the response is successful
        $response->assertStatus(200)
            ->assertExactJson([
                'User successfully updated.',
            ]);

        // Assert: check if the user is actually updated in the database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'UpdatedFirstName',
            'last_name' => 'UpdatedLastName',
            'email' => 'updatedemail@example.com',
        ]);
    }

    /** @test */
    public function it_fails_to_update_user_with_invalid_data()
    {
        // Arrange: create a user and log them in
        $user = User::factory()->create();
        Auth::login($user);

        // Invalid data (for example, an invalid email)
        $invalidData = [
            'email' => 'invalid-email', // Invalid email format
        ];

        // Act: send a PUT request with invalid data
        $response = $this->actingAs($user)->postJson('/api/update-user', $invalidData); // Adjust your route accordingly

        // Assert: check if the response is a validation error
        $response->assertStatus(422); // Unprocessable entity or validation error
    }
}
