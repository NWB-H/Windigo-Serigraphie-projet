<?php

declare(strict_types=1);

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

final class CategoryFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'int',
            'name' => 'required|string|unique:categories,name',
        ];
    }
}
