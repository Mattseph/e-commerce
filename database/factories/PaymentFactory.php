<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::pluck('id')->toArray();
        $order_id = Order::pluck('id')->toArray();

        return [
            'order_id' => fake()->randomNumber($order_id),
            'amount' => fake()->randomFloat(2),
            'status' => fake()->randomElement(['Status 1', 'Status 2']),
            'type' => fake()->randomElement(['Type 1', 'Type 2']),
            'created_by' => fake()->randomNumber($user_id),
            'updated_by' => fake()->randomNumber($user_id),

        ];
    }
}
