<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Services\Toast;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class ProductController
{
    public function index()
    {
        return Inertia::render(
            'Auth/Products',
            [
                'products' => Product::with(['category', 'option'])->get(),
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
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP,GIF,gif|max:2048'
        ]);

        // Gestion de l'image
        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('products', 'public');
        }

        try {
            Product::updateOrCreate(
                ['id' => $validated['id'] ?? null],
                $validated
            );

            Inertia::flash('toasts', [Toast::success('Produit enregistré avec succès')]);
        } catch (\Throwable $e) {
            Inertia::flash('toasts', [Toast::error('Une erreur est survenue.')]);
        }

        return to_route('admin.index');
    }
}