<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\ProductCart;
use App\Models\Product;
use Illuminate\Http\Request;
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
                    'shop.index.products',
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

    public function cart(Request $request)
    {
        $cart = json_decode($request->cookie('cart', []), true);
        $productsModel = Product::whereIn(
            'id',
            array_map(
                fn (array $product) => $product['product_id'],
                $cart,
            ),
        )->get();

        $products = [];
        $totalProducts = 0;
        $totalPrice = 0;

        foreach ($productsModel as $product) {
            $item = collect($cart)->firstWhere('product_id', $product->id);

            if (!$item) {
                continue;
            }

            $totalProducts += $item['quantity'];
            $totalPrice += $item['quantity'] * $product->price;

            $products[] = new ProductCart(
                product: $product,
                quantity: $item['quantity'],
            );
        }

        return Inertia::render(
            'Cart',
            [
                'products' => $products,
                'totalProducts' => $totalProducts,
                'totalPrice' => $totalPrice,
            ],
        );
    }
}
