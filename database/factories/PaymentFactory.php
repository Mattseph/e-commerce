<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Payment>
 */
class PaymentFactory extends Factory
{

    protected $model = Payment::class;
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
            'order_id' => fake()->randomElement($order_id),
            'amount' => fake()->randomFloat(2),
            'status' => fake()->randomElement(['Status 1', 'Status 2']),
            'type' => fake()->randomElement(['Type 1', 'Type 2']),
            'created_by' => fake()->randomElement($user_id),
            'updated_by' => fake()->randomElement($user_id),

        ];
    }
}
