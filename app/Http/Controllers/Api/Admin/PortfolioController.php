<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Controller;
use App\Models\PortfolioImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    // Liste des images publiques
    public function index()
    {
        return response()->json(PortfolioImage::all());
    }

    // Ajouter une image (admin)
    public function store(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'file', // On vérifie juste que c’est un fichier
                'mimes:jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP,GIF,gif', // Extensions seulement
                'max:2048', // Taille max 2 Mo
            ],
            'titre' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('portfolio', 'public');
        $url = env('APP_URL').'/storage/' . $path;

        $image = PortfolioImage::create([
            'titre' => $request->titre,
            'src' => $url,
        ]);

        return response()->json($image, 201);
    }

    // Supprimer une image (admin)
    public function destroy($id)
    {
        $image = PortfolioImage::findOrFail($id);

        // Supprimer le fichier physique si nécessaire
        if (Storage::disk('public')->exists(str_replace('/storage/', '', $image->src))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $image->src));
        }

        $image->delete();

        return response()->json(['message' => 'Image supprimée']);
    }
}
