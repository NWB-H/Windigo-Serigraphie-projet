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
                'pictures' => 'nullable|array',
                'pictures.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


        try {
            $product = Product::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated
            );

            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $picture) {
                    $product->addMedia($picture)->toMediaCollection('products');
                }
            }

            Inertia::notification('Produit enregistré avec succès', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Inertia::notification('Une erreur est survenure.', NotificationType::ERROR);
        }

        return to_route('admin.product.index');
    }
}
