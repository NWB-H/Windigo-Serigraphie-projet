<?php

declare(strict_types=1);

namespace App\Models\Dto;

class Image
{
    public function __construct(
        public int $id,
        public string $url,
        public bool $isHighlighted,
    ) {}
}
