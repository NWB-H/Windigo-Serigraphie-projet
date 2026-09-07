<?php

namespace App\Console\Commands\Email;

use App\Mail\AdminNewProductOrder;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAdminNewProductOrderEmail extends Command
{
    protected $signature = 'app:email:admin-new-product-order {orderId}';

    protected $description = 'Send the new product order notification email (emails.admin-new-product-order) to the admin';

    public function handle(): void
    {
        try {
            $order = Order::with('user')->where('id', $this->argument('orderId'))->first();

            if (! $order) {
                throw new \Exception('Order not found');
            }

            $this->info(
                sprintf('Sending admin new product order email to: %s', config('mail.from.admin'))
            );

            Mail::to(config('mail.from.admin'))->send(new AdminNewProductOrder($order));

            $this->info('Email sent');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
