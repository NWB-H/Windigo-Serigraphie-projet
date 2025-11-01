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

    // public function __construct() {
    //     parent::__construct();
    //     $this->date = new DateTime();
    // }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session_number'=> random_int(1,100),
            'capacity' => random_int(0,3),
            'workshop_id' => Workshop::inRandomOrder()->value('id'),
        ];
    }
    
}
