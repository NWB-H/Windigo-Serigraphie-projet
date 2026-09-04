<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\WorkshopEnum;
use App\Http\Requests\Form\WorkshopFormRequest;
use App\Http\Resources\PaginatedResourceArray;
use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Workshop;
use App\Models\WorkshopSession;
use App\Rules\WorkshopSessionFree;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

final class WorkshopController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Workshops',
            [
                'workshops' => fn () => new PaginatedResourceCollection(Workshop::orderByDesc('created_at')->paginate(20)),
                'types' => WorkshopEnum::values(),
            ],
        );
    }

    public function store(WorkshopFormRequest $request)
    {
        $validated = $request->validated();

        try {
            $workshop = Workshop::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated,
            );

            foreach ($validated['images'] as $key => $image) {
                $isHighlighted = $key === 0 || (bool) $image['isHighlighted'];

                if ($workshop->media->count() !== 0 && false === (bool) $image['isHighlighted']) {
                    $isHighlighted = false;
                }

                if ($isHighlighted) {
                    $workshop->resetHighlightedImages();
                }

                if ($request->hasFile("images.$key.file")) {
                    $media = $workshop
                        ->addMedia($request->file("images.$key.file"))
                        ->toMediaCollection('workshops');

                    if ($isHighlighted) {
                        $media->setCustomProperty('isHighlighted', true);
                        $media->save();
                    }
                }
            }

            Inertia::notification('Atelier créé avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error('Error on POST workshop', ['message' => $e->getMessage()]);
            Inertia::notification('Une erreur est survenu.', NotificationType::ERROR);
        }

        return back();
    }

    public function show(Workshop $workshop)
    {
        $sessions = $workshop
            ->workshopSessions()
            ->where('date', '>=', now())
            ->orderBy('date')
            ->paginate(10); // nombre de sessions par page

        $sessions->setCollection(
            $sessions->getCollection()->groupBy(fn ($session) => $session->date->format('Y-m-d'))
        );

        return Inertia::render(
            'Auth/Workshop',
            [
                'workshop' => $workshop,
                'sessionsList' => fn () => new PaginatedResourceArray($sessions),
            ],
        );
    }

    public function sessionStore(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'date' => ['bail', 'required', 'date', new WorkshopSessionFree($workshop)],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $validated['session_number'] = ((int) $workshop
                ->workshopSessions()
                ->max('session_number')) + 1;

            $workshop->workshopSessions()->create($validated);

            Inertia::notification('Session ajoutée avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error('Error on POST workshop session', [
                'error' => $e->getMessage(),
                'workshop_id' => $workshop->id,
            ]);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return back();
    }

    public function delete(Workshop $workshop, WorkshopSession $session)
    {
        try {
            $session->delete();

            Inertia::notification('Session supprimé avec succès', NotificationType::SUCCESS);

            return back();
        } catch (\Throwable $e) {
            Log::error('Error on DELETE workshop session', ['error' => $e->getMessage()]);
            Inertia::notification('Une erreur est survenu.', NotificationType::ERROR);
            return response(null, 500);
        }
    }
}
