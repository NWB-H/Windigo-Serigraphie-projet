<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['T-shirt', 'Sweat-shirts', 'Cartes et papeterie', 'Affiche'];
        foreach ($name as $value) {
            Category::create([
                'name' => $value,

            ]);
        }
    }
}
