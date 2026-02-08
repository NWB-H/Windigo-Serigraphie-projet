<?php

namespace Database\Factories;

use App\Models\Workshop;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkshopSession>
 */
class WorkshopSessionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'session_number'=> random_int(1,100),
            'capacity' => random_int(0,3),
            'workshop_id' => Workshop::inRandomOrder()->value('id'),
        ];
    }

}
