<?php

namespace App\Console\Commands;

use App\Events\StripePaymentSucceeded;
use App\Models\Order;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:test')]
#[Description('Command description')]
class Test extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order = Order::first();
        StripePaymentSucceeded::dispatch($order);
    }
}
