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
            'items.required' => 'Sipariş oluşturabilmek için ürün listesi gerekiyor',
            'items.min' => 'Sipariş oluşturabilmek için en az bir ürün gerekiyor',
            'items.*.product_id.required' => 'Ürünlerin id alanı boş olmamalı',
            'items.*.product_id.exists' => 'Bir veya daha fazla ürün sistemde yok',
            'items.*.quantity.required' => 'Ürünlerin miktarı beilrtilmek zorunda',
            'items.*.quantity.min' => 'Ürünlerin miktarı en az bir olmalıdır',
        ];
    }
}