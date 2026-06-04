<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

final class ForgotPasswordEmail extends Mailable
{
    public function __construct(
        public User $user
    ) {
    }

    public function content(): Content
    {
        $this->subject('Mot de passe oublié ?');

        $token = Str::random(64);

        User::where('email', $this->user->email)
            ->update([
                'reset_password_token' => $token,
                'reset_password_token_expires_at' => now()->addMinutes(60)
            ]);

        $url = Url::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(60),
            ['token' => $token],
        );

        return new Content(
            view: 'emails/forgot-password',
            with: [
                'verificationUrl' => $url,
            ]
        );
    }
}
