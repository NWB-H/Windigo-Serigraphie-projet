<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    public function delete(Request $request, Product $product)
    {
        try {
            $product->delete();
            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function deleteMedia(request $request, Product $product, Media $media)
    {
        try {
            $media->delete();
            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}
