<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Option;
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
            'name' => fake()->colorname(),
            'price' => random_int(0,50),
            'stock' => random_int(0,20),
            'description' => $this->faker->paragraph(1),
            'archived' => random_int(0,1),
            'option_id' => Option::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
