<?php

declare(strict_types=1);

namespace App\Http\Requests\Dto;

final class CheckoutProduct
{
    public function __construct(
        public int $id,
        public int $quantity,
        public float $price,
    ) {
    }
}
