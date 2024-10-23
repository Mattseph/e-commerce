<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Order>
 */
class OrderFactory extends Factory
{

    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::pluck('id')->toArray();
        $user_address_id = UserAddress::pluck('id')->toArray();

        return [
            'user_address_id' => fake()->randomNumber($user_address_id),
            'total_price' => fake()->randomFloat(2),
            'status' => fake()->randomElement(['Status1', 'Status2']),
            'session_id' => fake()->unique()->randomNumber(10),
            'created_by' => fake()->randomNumber($user_id),
            'updated_by' => fake()->randomNumber($user_id),
        ];
    }
}
