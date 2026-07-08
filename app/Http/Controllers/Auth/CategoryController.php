<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Form\CategoryFormRequest;
use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Category;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

final class CategoryController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Categories',
            [
                'categories' => fn () => new PaginatedResourceCollection(Category::paginate(10)),
            ]
        );
    }

    public function store(CategoryFormRequest $request)
    {
        $validated = $request->validated();

        try {
            Category::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated
            );

            Inertia::notification('Catégorie enregistré avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'enregistrement de la catégorie", ['error' => $e->getMessage(), 'category_id' => $validated['id'] ?? 'new category']);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return back();
    }
}
