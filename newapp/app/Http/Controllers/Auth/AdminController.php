<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Product;
use Inertia\Inertia;

final class AdminController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Admin',
            [
                'products' => Product::all(),
            ]
        );
    }
}