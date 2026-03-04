<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkshopSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'user_id' => User::inRandomOrder()->value('id'),
        'workshop_session_id' => WorkshopSession::inRandomOrder()->value('id')
        ];
    }
}
