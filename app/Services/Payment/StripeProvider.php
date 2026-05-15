<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\Dto\Checkout;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

final class StripeProvider
{
    private StripeClient $stripeClient;
    public const string STRIPE_SESSION_ID = 'intentId';

    public function __construct()
    {
        $this->stripeClient = new StripeClient(config('services.stripe.key'));
    }

    public function getIntentFromCheckoutFormValue(Checkout $checkout)
    {
        try {
            return $this->stripeClient->paymentIntents->create([
                'amount' => $checkout->total * 100,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
            ]);
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }

    public function getPaymentIntent(string $clientSecret, float $total): PaymentIntent
    {
        try {
            return $this->stripeClient->paymentIntents->update($clientSecret, [
                'amount' => intval($total * 100),
            ]);
        } catch (\Throwable $e) {
            // todo
            dd($e->getMessage());
        }
    }

    public function createOrRetriveFromSessionIntentId(CheckoutRequest $request)
    {
        $checkout = $request->value();

        return $request->session()->has(self::STRIPE_SESSION_ID)
            ? $this->getPaymentIntent($request->session()->get(self::STRIPE_SESSION_ID), $checkout->total)
            : $this->getIntentFromCheckoutFormValue($checkout);
    }
}
