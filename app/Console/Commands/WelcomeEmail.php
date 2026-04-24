<?php

namespace App\Console\Commands;

use App\Mail\RegisterEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WelcomeEmail extends Command
{
    protected $signature = 'app:welcome-email {userId}';

    protected $description = 'Send welcome email';

    public function handle()
    {
        try {
            $user = User::where('id', $this->argument('userId'))->first();

            if (! $user) {
                throw new \Exception('User not found');
            }

            $this->info(
                sprintf('Sending welcome email to: %s', $user->name)
            );

            Mail::to($user->email)->send(new RegisterEmail($user));

            $this->info('Email sent');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
