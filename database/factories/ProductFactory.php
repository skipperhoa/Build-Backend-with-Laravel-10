<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'title' => $this->faker->sentence(4),
            'keywords' => $this->faker->words(5, true),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'body' => $this->faker->text(500),
            'category_id' => 1,
            'user_id' => 1

        ];
    }
}
