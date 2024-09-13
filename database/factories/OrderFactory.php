<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => $this->faker->numberBetween(10,100),
            'user_id' => User::factory()->create()->id,
            'total' => 100.00,
            'shipping_address' => $this->faker->address,
            'status' => 1
        ];
    }
}
