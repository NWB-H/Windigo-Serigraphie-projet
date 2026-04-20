<?php

declare(strict_types=1);

namespace App\Models\Dto;

final class Image
{
    public function __construct(
        public int $id,
        public string $url,
        public bool $isHighlighted,
    ) {}
}
