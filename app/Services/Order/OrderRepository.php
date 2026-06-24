<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Events\StripePaymentSucceeded;
use App\Http\Requests\Dto\Checkout;
use App\Http\Requests\Dto\CheckoutProduct;
use App\Models\Dto\PaymentProvider;
use App\Models\Order;
use App\Services\Order\Exception\OrderByProviderIdNotFoundException;
use App\Services\Order\Exception\OrderCreationException;
use App\Services\Order\Exception\OrderSavePaymentSucceededException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class OrderRepository
{
    public function createOrderFromStripeCheckout(Checkout $checkout, string $providerId): void
    {
        try {
            $order = Order::where('payment_provider_id', $providerId)->first();

            if ($order) {
                return;
            }

            DB::transaction(function () use ($checkout, $providerId) {
                $order = Order::create(
                    [
                        'user_id' => auth()->id(),
                        'total' => $checkout->total,
                        'payment_provider_id' => $providerId,
                        'payment_provider_name' => PaymentProvider::STRIPE->value,
                        'status' => 'pending',
                    ]
                );

                $order->items()->createMany(
                    array_map(
                        fn (CheckoutProduct $item) => [
                            'product_id' => $item->id,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                        ],
                        $checkout->products
                    )
                );
            });
        } catch (\Throwable $e) {
            Log::error("Erreur lors de la création de la commande", ['error' => $e->getMessage()]);
            throw new OrderCreationException($e->getMessage());
        }
    }

    public function getByProviderId(string $providerId): ?Order
    {
        return Order::where('payment_provider_id', $providerId)->first();
    }

    public function registerOrderSucceededPayment(string $providerId): void
    {
        try {
            $order = $this->getByProviderId($providerId);

            if (null === $order) {
                throw new OrderByProviderIdNotFoundException($providerId);
            }

            $order->update([
                'status' => 'paid',
            ]);

            $order->save();

            StripePaymentSucceeded::dispatch();
        } catch (\Throwable $e) {
            throw new OrderSavePaymentSucceededException($e->getMessage());
        }

    }
}
