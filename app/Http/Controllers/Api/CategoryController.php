<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class CategoryController
{
    public function delete(Request $request, Category $category)
    {
        try {
            $category->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de la suppression d'un category", ['error' => $e->getMessage(), 'category_id' => $category->id]);
            return response()->json($e->getMessage(), 400);
        }
    }
}
