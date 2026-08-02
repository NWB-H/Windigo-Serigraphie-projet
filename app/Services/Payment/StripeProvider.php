<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Http\Requests\Form\CheckoutFormRequest;
use App\Http\Requests\Dto\Checkout;
use App\Services\Payment\Exception\StripeProviderException;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;
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

    public function getIntentFromCheckoutFormValue(Checkout $checkout): PaymentIntent
    {
        try {
            return $this->stripeClient->paymentIntents->create([
                'amount' => $checkout->total * 100,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
            ]);
        } catch (ApiErrorException $e) {
            Log::error("Erreur lors de la création de l'intent de paiement", ['error' => $e->getMessage()]);
            throw new StripeProviderException(message: "Erreur lors de la récupération de l'intent Stripe depuis la commande", previous: $e);
        }
    }

    public function getPaymentIntent(string $clientSecret, float $total): PaymentIntent
    {
        try {
            return $this->stripeClient->paymentIntents->update($clientSecret, [
                'amount' => intval($total * 100),
            ]);
        } catch (ApiErrorException $e) {
            Log::error("Erreur lors de la récupération de l'intent de paiement", ['error' => $e->getMessage()]);

            throw new StripeProviderException(message: "Erreur lors de la mise à jour de l'intent Stripe", previous: $e);
        }
    }

    public function createOrRetriveFromSessionIntentId(CheckoutFormRequest $request)
    {
        $checkout = $request->value();

        return $request->session()->has(self::STRIPE_SESSION_ID)
            ? $this->getPaymentIntent($request->session()->get(self::STRIPE_SESSION_ID), $checkout->total)
            : $this->getIntentFromCheckoutFormValue($checkout);
    }
}
