<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use App\Models\User;
use App\Services\Toast;
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

        dd('ok');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');

        }

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
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

            Inertia::flash('toasts', [Toast::success('Un email vous à été envoyé.')]);
        } catch (\Throwable $e) {
            Inertia::flash('toasts', [Toast::error('Une erreur est survenue.')]);
        }


        return to_route('login');
    }
}
