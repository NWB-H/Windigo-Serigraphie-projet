<?php

declare(strict_types=1);

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

final class LoginFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
