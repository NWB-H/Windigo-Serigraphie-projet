<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Webhook;

use App\Services\Order\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Event;
use Stripe\Webhook;

final class StripeWebhookController
{
    public function handleInvoicePaymentSucceeded(Request $request)
    {
        try {
            $webhook = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.webhook_secret'),
            );

            if ($webhook->type !== 'payment_intent.succeeded') {
                return response()->json(['message' => 'Invalid webhook event type'], 400);
            }

            return response()->json(['message' => 'Webhook processed successfully'], 200);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => 'Webhook processing failed'], 500);
        }
    }
}
