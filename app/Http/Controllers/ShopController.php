<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ShopController
{
    public function index()
    {
        return Inertia::render(
            'Shop',
            [
                'products' => Cache::remember(
                    'shop.indexx.products',
                    now()->addMinutes(10),
                    fn () => Product::with('media')->get(),
                ),
            ],
        );
    }

    public function item(Product $product)
    {
        return Inertia::render(
            'ProductItem',
            [
                'product' => $product,
            ]
        );
    }

    public function cart()
    {
        return Inertia::render('Cart');
    }
}
