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

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    /** @test */
    public function it_can_get_user_details()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->actingAs($user)->getJson('/api/get-user');

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
        $user = User::factory()->create();
        Auth::login($user);

        $updatedData = [
            'first_name' => 'UpdatedFirstName',
            'last_name' => 'UpdatedLastName',
            'email' => 'updatedemail@example.com',
            'gender' => 'Male',
            'date_of_birth' => '1991-11-07',
            'city' => 'Kuliyapitiya',
            'post_code' => '60200'
        ];

        $response = $this->actingAs($user)->postJson('/api/update-user', $updatedData); // Adjust your route accordingly

        $response->assertStatus(200)
            ->assertExactJson([
                'User successfully updated.',
            ]);

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
        $user = User::factory()->create();
        Auth::login($user);

        $invalidData = [
            'email' => 'invalid-email', // Invalid email format
        ];

        $response = $this->actingAs($user)->postJson('/api/update-user', $invalidData);

        $response->assertStatus(422);
    }
}
