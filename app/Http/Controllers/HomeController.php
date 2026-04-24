<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Workshop;
use Inertia\Inertia;

class HomeController
{
    public function index()
    {
        $products = Product::all();

        return Inertia::render(
            'Home',
            [
                'products' => $products->count() <= 3 ? $products : $products->random(3),
                'workshops' => Workshop::limit(2)->get(),
            ]
        );
    }
}
