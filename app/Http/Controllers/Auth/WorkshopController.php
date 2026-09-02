<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\WorkshopEnum;
use App\Http\Requests\Form\WorkshopFormRequest;
use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Workshop;
use App\Services\Notifications\NotificationType;
use Illuminate\Support\Facades\Log;
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
}
