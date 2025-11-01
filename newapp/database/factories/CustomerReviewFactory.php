<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerReview>
 */
class CustomerReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commentaire' => fake()->paragraph(),
            'note' => random_int(1,5),
            'product_id' => Product::Inrandomorder()->value('id'),
            'user_id' => User::Inrandomorder()->value('id')
        ];
    }
}
