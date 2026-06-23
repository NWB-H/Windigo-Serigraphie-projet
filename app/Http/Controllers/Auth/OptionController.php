<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Form\OptionFormRequest;
use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Option;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

final class OptionController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Options',
            [
                'options' => fn () => new PaginatedResourceCollection(Option::paginate(10)),
            ],
        );
    }

    public function store(OptionFormRequest $request)
    {
        $validated = $request->validated();

        try {
            Option::updateOrCreate(['id' => $validated['id'] ?? null], $validated);

            Inertia::notification('Option enregistré avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'enregistrement de l'option", ['error' => $e->getMessage(), 'option_id' => $validated['id'] ?? 'new option']);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return back();
    }
}
