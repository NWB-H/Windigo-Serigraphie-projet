<?php

namespace App\Listeners;

use App\Events\StripePaymentSucceeded;
use App\Mail\UserNewProductOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserConfirmedOrder
{

    public function handle(StripePaymentSucceeded $event): void
    {
        try {
            Mail::to($event->order->user->email)->send(new UserNewProductOrder($event->order));
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'envoi du mail de recapitulation d'une commande pour l'admin", ['error' => $e->getMessage()]);
            throw new \Exception($e->getMessage());
        }
    }
}
