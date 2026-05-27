<?php

declare(strict_types=1);

namespace App\Services\Order\Exception;

final class OrderByProviderIdNotFoundException extends \Exception
{
    public function __construct(string $providerId)
    {
        parent::__construct(
            \sprintf('Order with provider ID "%s" not found', $providerId),
            404
        );
    }
}
