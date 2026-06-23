<?php

declare(strict_types=1);

namespace App\Models\Exceptions;

final class UndefineCollectionName extends \Exception
{
    public function __construct()
    {
        parent::__construct('Collection name is not defined');
    }
}
