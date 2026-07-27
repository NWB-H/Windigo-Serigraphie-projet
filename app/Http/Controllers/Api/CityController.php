<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\City;

final class CityController
{
    public function search(string $postalCode)
    {
        return City::query()
            ->where('postal_code', 'like', $postalCode)
            ->orWhere('name', 'like', $postalCode)
            ->limit(10)
            ->get();
    }
}
