<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=CartItem>
 */
class CartItemFactory extends Factory
{

    protected $model = CartItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $product_id = Product::pluck('id')->toArray();

        return [
            'product_id' => fake()->randomElement($product_id),
            'quantity' => fake()->randomNumber(4),
        ];
    }
}
