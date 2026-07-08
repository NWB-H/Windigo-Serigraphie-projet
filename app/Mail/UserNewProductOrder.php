<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;

final class UserNewProductOrder extends Mailable
{
    public function __construct(
        public Order $order
    ) {
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/user-new-product-order',
            with: [
                'order' => $this->order->load(['user', 'products']),
            ],
        );
    }
}

