<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Option;
use App\Services\Toast;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class OptionController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Options',
            [
                'options' => Option::all(),
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

            Inertia::flash('toasts', [Toast::success('Option enregistré avec succès')]);
        } catch (\Throwable $e) {
            Inertia::flash('toasts', [Toast::error('Une erreur est survenue.')]);
        }

        return to_route('admin.options.index');
    }
}