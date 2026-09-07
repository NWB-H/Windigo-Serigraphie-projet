<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed test users, reusable for any CLI/email command that needs a userId
     * (e.g. app:email:register, app:email:forgot-password).
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
    }
}
