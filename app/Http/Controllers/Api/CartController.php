<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ➤ Ajouter ou mettre à jour un produit dans le panier
    public function set(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'cart'    => $cart->load('product')
        ]);
    }

    // ➤ Ajouter +1 sur un produit
    public function add($product_id)
    {
        $cart = Cart::where('product_id', $product_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            $cart = Cart::create([
                'user_id'   => Auth::id(),
                'product_id'=> $product_id,
                'quantity'  => 1
            ]);
        }

        return response()->json([
            'success' => true,
            'cart'    => $cart->load('product')
        ]);
    }

    // ➤ Retirer -1
    public function remove($product_id)
    {
        $cart = Cart::where('product_id', $product_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($cart) {
            $cart->decrement('quantity');
            if ($cart->quantity <= 0) {
                $cart->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Produit retiré du panier'
        ]);
    }

    // ➤ Récupérer le panier utilisateur
    public function show()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with('product') // inclut les infos produit
            ->get();

        return response()->json($cart);
    }

    // ➤ Vider le panier
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Panier vidé avec succès'
        ]);
    }

    // ➤ Supprimer complètement un produit
    public function delete($id)
    {
        $cart = Cart::where('product_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($cart) {
            $cart->delete();
            return response()->json([
                'success' => true,
                'message' => 'Produit supprimé du panier'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produit non trouvé dans le panier'
        ], 404);
    }
}
