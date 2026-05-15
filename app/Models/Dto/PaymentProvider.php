<?php

declare(strict_types=1);

namespace App\Models\Dto;

enum PaymentProvider: string
{
    case STRIPE = 'stripe';
}
