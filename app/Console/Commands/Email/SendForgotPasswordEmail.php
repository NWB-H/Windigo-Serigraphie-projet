<?php

namespace App\Console\Commands\Email;

use App\Mail\ForgotPasswordEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordEmail extends Command
{
    protected $signature = 'app:email:forgot-password {userId}';

    protected $description = 'Send the forgot password email (emails.forgot-password) to a user';

    public function handle(): void
    {
        try {
            $user = User::where('id', $this->argument('userId'))->first();

            if (! $user) {
                throw new \Exception('User not found');
            }

            $this->info(
                sprintf('Sending forgot password email to: %s', $user->name)
            );

            Mail::to($user->email)->send(new ForgotPasswordEmail($user));

            $this->info('Email sent');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
