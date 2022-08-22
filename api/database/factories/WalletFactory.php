<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::firstOrCreate(['id' => 1], User::factory()->make()->toArray());

        return [
            'user_id' => $user->id,
            'uuid'    => fake()->uuid(),
            'amount'  => fake()->numberBetween(0, 9999),
        ];
    }
}
