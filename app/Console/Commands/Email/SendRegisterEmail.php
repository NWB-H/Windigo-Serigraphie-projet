<?php

namespace App\Console\Commands\Email;

use App\Mail\RegisterEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendRegisterEmail extends Command
{
    protected $signature = 'app:email:register {userId}';

    protected $description = 'Send the register/welcome email (email-register) to a user';

    public function handle(): void
    {
        try {
            $user = User::where('id', $this->argument('userId'))->first();

            if (! $user) {
                throw new \Exception('User not found');
            }

            $this->info(
                sprintf('Sending register email to: %s', $user->name)
            );

            Mail::to($user->email)->send(new RegisterEmail($user));

            $this->info('Email sent');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
