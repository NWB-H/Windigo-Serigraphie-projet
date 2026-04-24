<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class RegisterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function content(): Content
    {
        $url = URL::temporarySignedRoute(
            'verify-account',
            now()->plus(minutes: 30),
            ['token' => Crypt::encryptString($this->user->id)]
        );

        return new Content(
            view: 'email-register',
            with: [
                'user' => $this->user,
                'verificationUrl' => $url,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
