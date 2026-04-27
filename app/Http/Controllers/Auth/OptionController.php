<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Option;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class OptionController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Options',
            [
                'options' => new PaginatedResourceCollection(Option::paginate(10)),
            ],
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'int',
            'name' => 'required|string|unique:options,name',
        ]);

        try {
            Option::updateOrCreate(['id' => $validated['id'] ?? null], $validated);

            Inertia::notification('Option enregistré avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return to_route('admin.options.index');
    }
}
