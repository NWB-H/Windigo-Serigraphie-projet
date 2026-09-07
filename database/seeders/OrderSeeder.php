<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Seed test orders (with their user and products attached), reusable for
     * any CLI/email command that needs an orderId
     * (e.g. app:email:user-new-product-order, app:email:admin-new-product-order).
     */
    public function run(): void
    {
        if (User::count() === 0) {
            User::factory()->count(10)->create();
        }

        if (Product::count() === 0) {
            Product::factory()->count(20)->create();
        }

        $userIds = User::pluck('id');
        $productIds = Product::pluck('id');

        Order::factory()
            ->count(10)
            ->state(fn () => [
                'user_id' => $userIds->random(),
                'shipping_line1' => fake()->streetAddress(),
                'shipping_line2' => null,
                'shipping_postal_code' => fake()->postcode(),
                'shipping_city' => fake()->city(),
                'shipping_country' => 'France',
            ])
            ->create()
            ->each(function (Order $order) use ($productIds): void {
                $products = $productIds->random(min(random_int(1, 5), $productIds->count()));

                $total = 0;

                foreach ($products as $productId) {
                    $quantity = random_int(1, 5);
                    $price = fake()->randomFloat(2, 5, 100);

                    $order->products()->attach($productId, [
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $total += $quantity * $price;
                }

                $order->update(['total' => $total]);
            });
    }
}
