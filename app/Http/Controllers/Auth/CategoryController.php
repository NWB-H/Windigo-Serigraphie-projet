<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class CategoryController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Categories',
            [
                'categories' => Category::all(),
            ]
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'int',
            'name' => 'required|string|unique:categories,name',
        ]);

        try {
            Category::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated
            );

            Inertia::notification('Catégorie enregistré avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return to_route('admin.categories.index');
    }
}
