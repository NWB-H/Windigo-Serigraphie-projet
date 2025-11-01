<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['S', 'M', 'L', 'XL'];
        foreach ($name as $value) {
            Option::create([
                'name' => $value,
            ]);
    }
}
}