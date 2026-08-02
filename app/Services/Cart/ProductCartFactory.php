<?php

declare(strict_types=1);

namespace App\Services\Cart;

use App\Models\Product;
use App\Services\Cart\Dto\ProductCart;
use App\Services\Cart\Dto\ProductCartCollection;

final class ProductCartFactory
{
    public const COOKIE_NAME = 'cart';

    public function getCurrentProductsInCart(): ProductCartCollection
    {
        $request = request();
        $cart = json_decode($request->cookie(self::COOKIE_NAME, ''), true);

        $productsModel = Product::whereIn(
            'id',
            array_map(
                fn (array $product) => $product['product_id'],
                $cart,
            ),
        )->get();

        $totalProducts = 0;
        $totalPrice = 0;

        $products = array_map(
            function (Product $product) use ($cart, &$totalProducts, &$totalPrice) {
                /** @var array{ quantity: int, product_id: int } $item */
                $item = collect($cart)->firstWhere('product_id', $product->id);

                if (!$item) {
                    return null;
                }

                $totalProducts += $item['quantity'];
                $totalPrice += $item['quantity'] * $product->price;

                return new ProductCart(
                    product: $product,
                    quantity: $item['quantity'],
                );
            },
            $productsModel->all(),
        );

        return new ProductCartCollection(
            products: array_filter($products),
            totalProducts: $totalProducts,
            totalPrice: $totalPrice,
        );
    }
}
