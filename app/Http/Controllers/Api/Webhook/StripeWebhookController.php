<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Webhook;

use App\Services\Order\Exception\OrderByProviderIdNotFoundException;
use App\Services\Order\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Event;
use Stripe\Webhook;

final readonly class StripeWebhookController
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {
    }

    public function handlePaymentIntentSucceeded(Request $request)
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

            $this->orderRepository->registerOrderSucceededPayment($webhook->data->object->id);

            return response()->json(['message' => 'Webhook processed successfully'], 200);
        } catch (OrderByProviderIdNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => 'Webhook processing failed'], 400);
        }
    }
}
