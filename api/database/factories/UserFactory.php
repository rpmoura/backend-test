<?php

namespace Database\Factories;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid'           => fake()->uuid(),
            'name'           => fake()->name(),
            'email'          => fake()->safeEmail(),
            'cpf_cnpj'       => fake('pt_BR')->cpf(),
            'type'           => UserTypeEnum::COMMON->value,
            'password'       => 'secret',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function shopkeeper()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => UserTypeEnum::SHOPKEEPER->value,
            ];
        });
    }
}
