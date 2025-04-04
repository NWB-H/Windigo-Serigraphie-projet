<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', 'min:8'],
            'delivery_address' => 'nullable|exists:cities,id',
            'billing_address' => 'nullable|exists:cities,id',
        ]);

        $user = new User();
        $user->fill($formFields);
        $user->token = Str::random(40);
        $user->save();

        Mail::to($user->email)->send(new RegisterEmail($user));



        return response()->json(['success' => 'success']);
    }

    public function verification(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'token' => 'required|string|exists:users,token'
        ]);

        $user = User::where('email', $formFields['email'])
        ->where('token', $formFields['token'])
        ->first();

        if (!$user) {
            return response()->json(['failed' => 'failed', 400]);
        }


        $user->email_verified_at = now();
        $user->save();

        return response()->json(['success' => 'success']);
    }
}
