<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use App\Models\User;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SecurityController
{
    public function login()
    {
        return Inertia::render(
            'Login'
        );
    }

    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Inertia::notification('Bienvenue sur votre espace personnels.', NotificationType::SUCCESS);

            return to_route('home');
        }

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->back();
    }

    public function register()
    {
        return Inertia::render(
            'Register'
        );
    }

    public function registerStore(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        $formFields['password'] = Hash::make($formFields['password']);

        $user = new User();
        $user->fill($formFields);
        $user->token = Str::random(40);

        $user->save();

        try {
            Mail::to($user->email)->send(new RegisterEmail($user));

            Inertia::notification('Un email vous à été envoyé.', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }


        return to_route('login');
    }
}
