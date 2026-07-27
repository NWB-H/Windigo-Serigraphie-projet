<?php

namespace App\Dto;

use App\Models\Product;

class ProductCart
{
    public function __construct(
        public Product $product,
        public int $quantity,
    ) {
    }
}
