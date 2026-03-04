<?php

namespace Database\Factories;

use App\Enums\WorkshopEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshop>
 */
class WorkshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->domainName(),
            'type' => WorkshopEnum::random(),
            'price' => random_int(0,50),
            'duration'=> $this->faker->time(),
            'age'=> 15,
        ];
    }
}
