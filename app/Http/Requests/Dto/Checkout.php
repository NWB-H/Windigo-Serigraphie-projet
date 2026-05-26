<?php

declare(strict_types=1);

namespace App\Http\Requests\Dto;

final class Checkout
{
    /**
     * @param array<CheckoutProduct> $products
     */
    public function __construct(
        public int $quantity,
        public float $total,
        public array $products = [],
    ) {
    }
}
