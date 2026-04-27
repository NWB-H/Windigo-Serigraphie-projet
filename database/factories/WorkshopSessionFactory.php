<?php

namespace Database\Factories;

use App\Models\Workshop;
use App\Models\WorkshopSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkshopSession>
 */
class WorkshopSessionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'session_number' => random_int(1, 100),
            'capacity' => random_int(0, 3),
            'workshop_id' => Workshop::inRandomOrder()->value('id'),
        ];
    }
}
