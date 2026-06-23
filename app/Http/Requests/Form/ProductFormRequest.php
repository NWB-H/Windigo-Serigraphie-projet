<?php

declare(strict_types=1);

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

final class ProductFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'int',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'archived' => 'boolean',
            'option_id' => 'required|exists:options,id',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*.file' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'images.*.isHighlighted' => 'boolean',
        ];
    }
}
