<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart\Dto\ProductCart;
use App\Services\Cart\Dto\ProductCartCollection;
use App\Services\Cart\ProductCartFactory;
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

    public function cart(Request $request, ProductCartFactory $productCartFactory)
    {
        $productCart = $productCartFactory->getCurrentProductsInCart();

        return Inertia::render(
            'Cart',
            [
                'products' => $productCart->products,
                'totalProducts' => $productCart->totalProducts,
                'totalPrice' => $productCart->totalPrice,
            ],
        );
    }

    public function summaryCart(ProductCartFactory $productCartFactory)
    {
        $productCart = $productCartFactory->getCurrentProductsInCart();

        return Inertia::render(
            'SummaryCart',
            [
                'products' => $productCart->products,
                'totalProducts' => $productCart->totalProducts,
                'totalPrice' => $productCart->totalPrice,
            ],
        );
    }
}
