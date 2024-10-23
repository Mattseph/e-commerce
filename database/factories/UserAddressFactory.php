<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=UserAddress>
 */
class UserAddressFactory extends Factory
{

    protected $model = UserAddress::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user_id = User::pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($user_id),
            'type' => fake()->text(45),
            'address1' => fake()->address(),
            'address2' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->city(),
            'zipcode' => fake()->randomNumber(4),
            'isMain' => fake()->boolean(),
            'country_code' => fake()->randomNumber(3),
        ];
    }
}
