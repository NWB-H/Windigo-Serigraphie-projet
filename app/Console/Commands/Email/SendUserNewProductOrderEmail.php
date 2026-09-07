<?php

namespace App\Console\Commands\Email;

use App\Mail\UserNewProductOrder;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendUserNewProductOrderEmail extends Command
{
    protected $signature = 'app:email:user-new-product-order {orderId}';

    protected $description = 'Send the new product order confirmation email (emails.user-new-product-order) to the ordering user';

    public function handle(): void
    {
        try {
            $order = Order::with('user')->where('id', $this->argument('orderId'))->first();

            if (! $order) {
                throw new \Exception('Order not found');
            }

            if (! $order->user) {
                throw new \Exception('Order has no associated user');
            }

            $this->info(
                sprintf('Sending user new product order email to: %s', $order->user->email)
            );

            Mail::to($order->user->email)->send(new UserNewProductOrder($order));

            $this->info('Email sent');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
