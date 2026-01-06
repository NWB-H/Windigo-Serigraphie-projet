<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ShopController
{
    public function index()
    {
        return Inertia::render(
            'Shop',
            [
                'products' => Product::all(),
            ]
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
}
