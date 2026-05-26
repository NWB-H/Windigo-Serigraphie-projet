<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use App\Models\User;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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

        if (
            Auth::attemptWhen(
                $credentials,
                function (User $user) {
                    return $user->email_verified_at !== null;
                }
            )
        ) {
            $request->session()->regenerate();

            Inertia::notification('Bienvenue sur votre espace personnels.', NotificationType::SUCCESS);

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
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

        $user = new User;
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

    public function verifyAccount(Request $request)
    {
        $userId = Crypt::decryptString($request->query('token'));

        $user = User::where('id', $userId);

        $isVerifyAccount = $user && $request->hasValidSignature();

        if ($isVerifyAccount) {
            $user->update([
                'email_verified_at' => now(),
            ]);
        }

        return Inertia::render(
            'VerifyAccount', ['isVerifyAccount' => $isVerifyAccount]
        );
    }
}
