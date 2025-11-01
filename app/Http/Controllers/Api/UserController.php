<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')
            ],
            'password' => ['required', 'confirmed', 'min:8'],
            'delivery_address' => 'nullable|exists:cities,id',
            'billing_address' => 'nullable|exists:cities,id',
        ]);


        $user = new User();
        $user->fill($formFields);
        $user->role = 'ROLE_USER';
        $user->token = Str::random(40);
        $user->save();
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $formFields = $request->validate([
            'name' => 'string',
            'email' => ['string', 'email', 'max:255', Rule::unique(
                'users',
                'email'
            )],
        ]);

        $user->fill($formFields);
        $user->save();
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => 'success']);
    }
}
