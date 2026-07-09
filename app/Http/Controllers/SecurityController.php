<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\ForgotPasswordFormRequest;
use App\Http\Requests\Form\LoginFormRequest;
use App\Http\Requests\Form\RegisterFormRequest;
use App\Http\Requests\Form\ResetPasswordFormRequest;
use App\Mail\ForgotPasswordEmail;
use App\Mail\RegisterEmail;
use App\Models\User;
use App\Services\Notifications\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

    public function loginStore(LoginFormRequest $request)
    {
        $credentials = $request->validated();

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

    public function registerStore(RegisterFormRequest $request)
    {
        $formFields = $request->validated();
        $formFields['password'] = Hash::make($formFields['password']);

        $user = new User;
        $user->fill($formFields);
        $user->token = Str::random(40);

        $user->save();

        try {
            Mail::to($user->email)->send(new RegisterEmail($user));

            Inertia::notification('Un email vous à été envoyé.', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'envoie de l'email d'inscription", ['error' => $e->getMessage()]);
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

    public function forgotPassword()
    {
        return Inertia::render(
            'ForgotPassword'
        );
    }

    public function forgotPasswordStore(ForgotPasswordFormRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = User::where('email', $validated['email'])->firstOrFail();

            Mail::to($user->email)->send(new ForgotPasswordEmail($user));

            Inertia::notification('Un emails vous à été envoyé.', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'envoie de l'email du mot de passe oublié", ['error' => $e->getMessage()]);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return back();
    }

    public function resetPassword(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        return Inertia::render(
            'ResetPassword',
            [
                'formUrl' => $request->fullUrl(),
            ]
        );
    }

    public function resetPasswordStore(ResetPasswordFormRequest $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $request->validated();

        try {
            $user = User::where('reset_password_token', $request->query('token'))->whereDate('reset_password_token_expires_at', '>=', now())->firstOrFail();

            $user->update([
                'password' => Hash::make($request->password),
                'reset_password_token' => null,
                'reset_password_token_expires_at' => null,
            ]);

            Inertia::notification('Votre mot de passe a été mis à jour.', NotificationType::SUCCESS);
        } catch (\Throwable $e) {
            Log::error("Erreur lors de la mise à jour du mot de passe", ['error' => $e->getMessage()]);
            Inertia::notification('Une erreur est survenue.', NotificationType::ERROR);
        }

        return to_route('login');
    }

    public function profile()
    {
        Auth::user()->load('addresses.city');

        return Inertia::render('Profile');
    }
}
