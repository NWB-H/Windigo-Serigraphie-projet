<?php

namespace App\Listeners;

use App\Events\StripePaymentSucceeded;
use App\Mail\AdminNewProductOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewConfirmedOrder
{
    public function handle(StripePaymentSucceeded $event): void
    {
        try {
            $order = $event->order;
            Mail::to($order->user()->value('email'))->send(new AdminNewProductOrder($order));
        } catch (\Throwable $e) {
            Log::error("Erreur lors de l'envoi du mail de recapitulation d'une commande pour l'admin", ['error' => $e->getMessage()]);
            throw new \Exception($e->getMessage());
        }
    }
}
