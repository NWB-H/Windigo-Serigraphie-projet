<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Http\Requests\Dto\Checkout;
use App\Http\Requests\Dto\CheckoutProduct;
use App\Models\Dto\PaymentProvider;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

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
            dd($e->getMessage());
        }
    }
}
