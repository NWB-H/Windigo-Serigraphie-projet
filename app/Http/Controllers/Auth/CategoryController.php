<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use App\Services\Toast;
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

            Inertia::flash('toasts', [Toast::success('Catégorie enregistré avec succès')]);
        } catch (\Throwable $e) {
            Inertia::flash('toasts', [Toast::error('Une erreur est survenue.')]);
        }

        return to_route('admin.categories.index');
    }
}