<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * @todo: changer la façon de générer le token, pas sécure, pas de time limit
 */
class RegisterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function build()
    {
        $verificationUrl = url("/api/verification?email={$this->user->email}&token={$this->user->token}");

        return $this->subject('Confirmez votre inscription')
                    ->view('email-register', [
                        'user' => $this->user,
                        'verificationUrl' => $verificationUrl,
                    ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
