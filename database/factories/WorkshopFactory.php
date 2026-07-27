<?php

namespace Database\Factories;

use App\Enums\WorkshopEnum;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Workshop>
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
            'price' => random_int(0, 50),
            'duration' => random_int(0, 50),
            'age' => 15,
        ];
    }
}
