<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use Inertia\Inertia;

final class CategoryController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Categories',
            [
                'categories' => Category::all(),
            ]
        );
    }
}