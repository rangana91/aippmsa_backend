<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => 'shirt',
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'image' => $this->faker->imageUrl,
            'price' => $this->faker->numberBetween(10, 100),
            'description' => $this->faker->text
        ];
    }
}
