<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopSession;
use Database\Factories\WorkshopFactory;
use Database\Factories\WorkshopSessionFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory()->count(50)->create();

        Workshop::factory()
            ->count(10)
            ->create();
    }
}
