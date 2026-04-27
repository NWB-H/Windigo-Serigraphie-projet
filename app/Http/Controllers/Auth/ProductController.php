<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Resources\PaginatedResourceCollection;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'int',
            'name' => 'required|string',
            'price' => 'required|integer|between:1,50',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'archived' => 'boolean',
            'option_id' => 'required|exists:options,id',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*.file' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'images.*.isHighlighted' => 'boolean',
        ]);

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
            Inertia::notification('Une erreur est survenure.', NotificationType::ERROR);
        }

        return back();
    }
}
