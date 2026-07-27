<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

class AddressFormRequest extends FormRequest implements FormRequestInterface
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->user()->id
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'int',
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string'],
            'address_line1' => ['required', 'string'],
            'address_line2' => ['nullable', 'string'],
            'postal_code' => ['required', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de l’adresse est obligatoire.',
            'address_line1.required' => 'La première ligne de l’adresse est obligatoire.',
            'postal_code.required' => 'Le code postal est obligatoire.',
            'country.required' => 'Le pays est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
        ];
    }

    public function value(): mixed
    {
        throw new \LogicException('This method is not implemented yet.');
    }
}
