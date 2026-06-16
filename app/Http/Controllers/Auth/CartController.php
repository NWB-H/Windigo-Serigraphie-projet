<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\CheckoutFormRequest;
use App\Services\Order\OrderRepository;
use App\Services\Payment\StripeProvider;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

final readonly class CartController
{
    public function __construct(
        private StripeProvider  $stripe,
        private OrderRepository $orderRepository,
    ) {
    }

    public function checkout(CheckoutFormRequest $request)
    {
        try {
            $checkout = $request->value();

            $intent = $this->stripe->createOrRetriveFromSessionIntentId($request);

            $this->orderRepository->createOrderFromStripeCheckout($checkout, $intent->id);

            $request->session()->put('intentId', $intent->id);

            return Inertia::render('Auth/Checkout', [
                'clientSecret' => $intent->client_secret,
            ]);
        } catch (\Throwable $e) {
            Log::error("Erreur lors du paiement", ['error' => $e->getMessage()]);
            return redirect()->to('home');
        }
    }
}
