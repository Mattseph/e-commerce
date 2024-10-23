<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=OrderItem>
 */
class OrderItemFactory extends Factory
{

    protected $model = OrderItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $product_id = Product::pluck('id')->toArray();
        $order_id = Order::pluck('id')->toArray();

        return [
            'product_id' => fake()->randomElement($product_id),
            'order_id' => fake()->randomElement($order_id),
            'quantity' => fake()->randomNumber(4),
            'unit_price' => fake()->randomFloat(2),
        ];
    }
}
