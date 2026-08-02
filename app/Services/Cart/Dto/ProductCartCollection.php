<?php

declare(strict_types=1);

namespace App\Services\Cart\Dto;

final class ProductCartCollection
{
    public function __construct(
        public array $products,
        public int $totalProducts,
        public float $totalPrice,
    ) {
    }
}
