<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
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

        $product = Product::create($validated);

        // Ajouter l'URL complète de l'image
        $product->picture_url = $product->picture
            ? asset('storage/' . $product->picture)
            : null;

        return back();
    }
}