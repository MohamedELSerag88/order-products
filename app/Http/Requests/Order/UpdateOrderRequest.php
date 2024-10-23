<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\ResponseShape as FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       return auth()->user()->can('update orders');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "product_name" => "required",
            "unit_price" => "required",
            "quantity" => "required|integer",
            "status" => "required|in:Pending,Paid,Canceled",
        ];
    }
}
