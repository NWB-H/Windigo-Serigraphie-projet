<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    public function delete(Request $request, Product $product)
    {
        try {
            $product->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de la suppression d'un product", ['error' => $e->getMessage(), 'product_id' => $product->id]);
            return response()->json($e->getMessage(), 400);
        }
    }

    public function deleteMedia(Request $request, Product $product, Media $media)
    {
        try {
            $media->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de la suppression d'un media de produit", ['error' => $e->getMessage(), 'media_id' => $media->id, 'product_id' => $product->id]);
            return response()->json($e->getMessage(), 400);
        }
    }

    public function highlightImage(Request $request, Product $product, Media $media)
    {
        try {
            $product->resetHighlightedImages();
            $media->setCustomProperty('isHighlighted', true)->save();
        } catch (\Throwable $e) {
            Log::error("Erreur lors de la mise en évidence d'une image de produit", ['error' => $e->getMessage(), 'media_id' => $media->id, 'product_id' => $product->id]);
            return response()->json($e->getMessage(), 400);
        }
    }
}
