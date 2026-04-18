<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

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
                'products' => [Product::with(['category', 'option'])->latest('id')->first()],
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
            $product = Product::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated
            );

            foreach ($validated['images'] as $key => $image) {
                if ($request->hasFile("images.$key.file")) {
                    $product
                        ->addMedia($request->file("images.$key.file"))
                        ->withCustomProperties(['isHighlighted' => (bool) $image['isHighlighted']])
                        ->toMediaCollection('products');
                }
            }

            Inertia::notification('Produit enregistré avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            dd($e->getMessage());
            Inertia::notification('Une erreur est survenure.', NotificationType::ERROR);
        }

        return to_route('admin.product.index');
    }
}
