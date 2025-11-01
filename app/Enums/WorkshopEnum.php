<?php
namespace App\Enums;

use App\Traits\EnumTrait;

enum WorkshopEnum: string
{
    use EnumTrait;

    case TEXTILE = 'TEXTILE';
    case PAPIER = 'PAPIER';
}