<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\Dto\Address;
use App\Http\Requests\Dto\Checkout;
use App\Http\Requests\Dto\CheckoutProduct;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutFormRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'totalPrice' => ['required', 'numeric'],
            'totalProducts' => ['required', 'numeric'],
            'address' => ['required', 'array'],
            'address.line1' => ['required', 'string'],
            'address.line2' => ['nullable', 'string'],
            'address.city' => ['required', 'string'],
            'address.postal_code' => ['required', 'string'],
            'address.country' => ['required', 'string'],
            'items.*' => ['required', 'array'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.product_price' => ['required', 'numeric'],
            'items.*.product_id' => ['required', 'numeric'],
        ];
    }

    public function value(): Checkout
    {
        return new Checkout(
            quantity: $this->integer('totalProducts'),
            total: $this->integer('totalPrice'),
            address: new Address(
                line1: $this->string('address.line1'),
                line2: $this->string('address.line2'),
                city: $this->string('address.city'),
                postalCode: $this->string('address.postal_code'),
                country: $this->string('address.country'),
            ),
            products: array_map(
                fn ($item) => new CheckoutProduct(
                    id: $item['product_id'],
                    quantity: $item['quantity'],
                    price: $item['product_price'],
                ),
                $this->array('items'),
            )
        );
    }
}
