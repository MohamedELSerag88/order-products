<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\ResponseShape as FormRequest;
use App\Rules\AvailableQuantity;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "items" => "required|array",
            "items.*.product_id" => "required|integer|exists:products,id",
            "items.*.quantity" => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $productId = $this->input("items.$index.product_id");
                    $rule = new AvailableQuantity($productId);
                    $rule->validate($attribute, $value, $fail);
                }
            ]
        ];
    }
}
