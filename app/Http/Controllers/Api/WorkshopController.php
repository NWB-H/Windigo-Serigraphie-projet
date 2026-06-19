<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class WorkshopController extends Controller
{
    public function delete(Request $request, Workshop $workshop)
    {
        try {
            $workshop->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function highlightImage(Request $request, Workshop $workshop, Media $media)
    {
        try {
            $workshop->resetHighlightedImages();

            $media->setCustomProperty('isHighlighted', true)->save();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            Log::error('Erreur lors de la mise en évidence d\'une image de workshop', ['error' => $e->getMessage(), 'media_id' => $media->id, 'workshop_id' => $workshop->id]);
            return response()->json($e->getMessage(), 400);
        }
    }

    public function deleteMedia(Request $request, Workshop $workshop, Media $media)
    {
        try {
            $media->delete();

            return response()->json(null, 204);
        } catch (\Throwable $e) {
            Log::error('Erreur lors de la suppression d\'un media de workshop', ['error' => $e->getMessage(), 'media_id' => $media->id, 'workshop_id' => $workshop->id]);
            return response()->json($e->getMessage(), 400);
        }
    }
}
