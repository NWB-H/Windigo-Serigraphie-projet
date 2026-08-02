<?php

namespace App\Http\Requests\Dto;

class Address
{
    public function __construct(
        public string $line1,
        public ?string $line2,
        public string $city,
        public string $postalCode,
        public string $country
    ) {
    }
}
