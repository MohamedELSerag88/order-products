<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class;
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 1, 100);
        return [
            'name' => fake()->word(),
            'price' => $price,
            'image' => fake()->imageUrl,
            'quantity' => fake()->numberBetween(2,100),
        ];
    }


}
