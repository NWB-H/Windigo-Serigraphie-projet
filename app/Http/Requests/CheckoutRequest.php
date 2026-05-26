<?php

namespace App\Http\Requests;

use App\Http\Requests\Dto\Checkout;
use App\Http\Requests\Dto\CheckoutProduct;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'totalPrice' => ['required', 'numeric'],
            'items.*' => ['required', 'array'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.product' => ['required', 'array'],
            'items.*.product.price' => ['required', 'numeric'],
            'items.*.product.id' => ['required', 'numeric'],
        ];
    }

    public function value(): Checkout
    {
        return new Checkout(
            quantity: array_reduce(
                $this->array('items'),
                fn ($total, $item) => $total + $item['quantity'],
            ),
            total: $this->integer('totalPrice'),
            products: array_map(
                fn ($item) => new CheckoutProduct(
                    id: $item['product']['id'],
                    quantity: $item['quantity'],
                    price: $item['product']['price'],
                ),
                $this->array('items'),
            )
        );
    }
}
