<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;

final class CategoryController
{
    public function delete(Request $request, Category $category)
    {
        try {
            $category->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}
