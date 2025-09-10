<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->query('name');
        $minPrice = $request->query('minPrice');
        $maxPrice = $request->query('maxPrice');
        $option = $request->query('option');
        $category = $request->query('category');
        $product = Product::search($name, $minPrice, $maxPrice, $option, $category);

        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer|between:1,50',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'archived' => 'required|integer',
            'option_id' => 'required|exists:options,id',
            'category_id' => 'required|exists:categories,id',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP,GIF,gif|max:2048'
        ]);

        $product = new Product();
        $product->fill($formFields);

        if ($request->file('picture')) {
            $fileName = time() . '_' . $request->picture->getClientOriginalName();
            $path = 'images/uploads/' . $fileName;
            $product->avatar = $fileName;
            $request->picture->move(public_path('images/uploads'), $path);
        }
        $product->save();
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Product::with(['category', 'option'])->findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $formFields = $request->validate([
            'name' => 'string',
            'price' => 'integer',
            'stock' => 'integer',
            'detail' => 'string',
            'archived' => 'integer',
            'option_id' => 'exists:options,id',
            'category_id' => 'exists:categories,id',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP,GIF,gif|max:2048'
        ]);

        // Suppression si l'utilisateur a supprimé l'image
        if ($request->has('picture') && !$request->file('picture')) {
            if (File::exists(public_path('images/uploads/' . $product->avatar))) {
                File::delete(public_path('images/uploads/' . $product->avatar));
            }
            $product->avatar = null;
        }

        // Si nouvel upload
        if ($request->file('picture')) {
            if (File::exists(public_path('images/uploads/' . $product->avatar))) {
                File::delete(public_path('images/uploads/' . $product->avatar));
            }
            $fileName = time() . '_' . $request->picture->getClientOriginalName();
            $product->avatar = $fileName;
            $request->picture->move(public_path('images/uploads'), $fileName);
        }

        $product->fill($formFields);
        $product->save();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $request->validated();
        if (File::exists(public_path('images/uploads/' . $product->picture))) {
            File::delete(public_path('images/uploads/' . $product->picture));
        }
        $product->delete();
        return response()->json(['success' => 'success']);
    }

    public function paginate(Request $request)
    {
        $page = $request->query('page', 1);
        $name = $request->query('name');
        $minPrice = $request->query('minPrice');
        $maxPrice = $request->query('maxPrice');
        $option = $request->query('option_id');
        $category = $request->query('category_id');
        $limit = 3;
        $results = Product::search($name, $minPrice, $maxPrice, $option, $category, /*$page, $limit*/);
        $maxPages = ceil($results['totalResults'] / $limit);
        return response()->json([
            'products' => $results['products'],
            'maxPages' => $maxPages,
            'page' => $page
        ]);
    }
}
