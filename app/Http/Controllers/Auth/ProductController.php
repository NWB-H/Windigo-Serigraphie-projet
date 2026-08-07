<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Form\ProductFormRequest;
use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

final class ProductController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Products',
            [
                'productsPaginated' => fn () => new PaginatedResourceCollection(Product::with(['category', 'option'])->paginate(10)),
                'options' => Option::all(),
                'categories' => Category::all(),
            ],
        );
    }

    public function store(ProductFormRequest $request)
    {
        $validated = $request->validated();

        try {
            /** @var Product $product */
            $product = Product::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated
            );

            foreach ($validated['images'] as $key => $image) {
                if ($request->hasFile("images.$key.file")) {
                    $isHighlighted = (bool) $image['isHighlighted'];

                    if ($isHighlighted) {
                        $product->resetHighlightedImages();
                    }

                    $product
                        ->addMedia($request->file("images.$key.file"))
                        ->withCustomProperties(['isHighlighted' => $isHighlighted])
                        ->toMediaCollection('products');
                }
            }

            Inertia::notification('Produit enregistré avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'enregistrement du produit", ['error' => $e->getMessage(), 'product_id' => $validated['id'] ?? 'new product']);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return back();
    }
}
