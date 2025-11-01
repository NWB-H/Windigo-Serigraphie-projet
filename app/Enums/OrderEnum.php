<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum OrderStatus: string
{
     use EnumTrait;
    case PENDING = 'en attente';
    case PAID = 'payée';
    case SHIPPED = 'expédiée';
    case CANCELLED = 'annulée';
}
