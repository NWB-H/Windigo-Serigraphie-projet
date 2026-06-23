<?php

declare(strict_types=1);

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

final class WorkshopFormRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'id' => 'int',
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'duration' => ['required', 'integer', 'min:1'],
            'age' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'images' => 'nullable|array',
            'images.*.file' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'images.*.isHighlighted' => 'boolean',
        ];
    }

    public function value(): mixed
    {
        throw new \LogicException('Method value() is not implemented');
    }
}
