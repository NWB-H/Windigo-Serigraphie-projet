<?php

namespace Database\Seeders;

use App\Models\Workshop;
use Carbon\Doctrine\CarbonTypeConverter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workshop::create([
            'name' => 'Sérigraphiez votre T-shirt ou votre sac sur-mesure',
            'type' => 'TEXTILE',
            'price' => 55,
            'duration'=> '2:00:00',
            'age'=> 15,
          ]);

          Workshop::create([
            'name' => 'Initiez vous à la sérigraphie sur papier',
            'type' => 'PAPIER',
            'price' => 40,
            'duration'=> '2:30:00',
            'age'=> 15,
          ]);
    }
}
