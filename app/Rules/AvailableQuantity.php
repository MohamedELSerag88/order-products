<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableQuantity implements ValidationRule
{

    protected $productId;

    /**
     * Create a new rule instance.
     *
     * @param  int  $productId
     * @return void
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = \DB::table('products')->where('id', $this->productId)->first();
        if ($value > $product->quantity) {

            $fail('The quantity for product ' . $product->name . ' exceeds available stock.');
        }
    }
}
