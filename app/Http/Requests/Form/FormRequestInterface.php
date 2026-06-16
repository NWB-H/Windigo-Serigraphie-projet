<?php

declare(strict_types=1);

namespace App\Http\Requests\Form;

interface FormRequestInterface
{
    public function value(): mixed;
}
