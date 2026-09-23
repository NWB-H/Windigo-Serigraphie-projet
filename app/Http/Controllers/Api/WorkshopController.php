<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkshopSessionResource;
use App\Models\Workshop;
use App\Models\WorkshopSession;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
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

    public function filterWorkshopSessions(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d'],
        ]);

        try {
            $sessions = WorkshopSession::where('workshop_id', $workshop->id)
                ->withCount('reservations')
                ->when(
                    $validated['date'] ?? null,
                    function ($query, $date) {
                        $date = Carbon::parse($date);

                        $query->whereBetween('date', [
                            $date->copy()->startOfMonth(),
                            $date->copy()->endOfMonth(),
                        ]);
                    },
                )
                ->oldest('date')
                ->get();

            return response()->json(
                $sessions
                    ->groupBy(fn ($session) => $session->date->format('Y-m-d'))
                    ->map(fn ($group) => WorkshopSessionResource::collection($group)),
                200);
        } catch (\Throwable $e) {
            Log::error('Erreur lors du filtrage des sessions de workshop', ['error' => $e->getMessage()]);
            Inertia::notification($e->getMessage(), NotificationType::ERROR);
            return response()->json($e->getMessage(), 400);
        }
    }
}
