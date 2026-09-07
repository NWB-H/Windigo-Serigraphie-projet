<?php

namespace App\Console\Commands\Email;

use App\Mail\ContactEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendContactEmail extends Command
{
    protected $signature = 'app:email:contact {recipient} {senderEmail} {message}';

    protected $description = 'Send the contact form email (emails.contact-form) to a recipient';

    public function handle(): void
    {
        try {
            $recipient = $this->argument('recipient');

            $this->info(
                sprintf('Sending contact email to: %s', $recipient)
            );

            Mail::to($recipient)->send(
                new ContactEmail($this->argument('senderEmail'), $this->argument('message'))
            );

            $this->info('Email sent');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
