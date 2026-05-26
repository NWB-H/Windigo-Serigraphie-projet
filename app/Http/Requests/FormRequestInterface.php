<?php

declare(strict_types=1);

namespace App\Http\Requests;

interface FormRequestInterface
{
    public function value(): mixed;
}
