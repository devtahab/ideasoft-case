<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreOrderPreviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1']
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'items.required' => 'Products are needed for creating an order',
            'items.min' => 'There should be at least one product for creating an order',
            'items.*.product_id.required' => 'Product id is required for products in the order',
            'items.*.product_id.exists' => 'One or more order products are not exist',
            'items.*.quantity.required' => 'Quantity is required for products in the order',
            'items.*.quantity.min' => 'Quantity should be one or more for the products',
        ];
    }
}