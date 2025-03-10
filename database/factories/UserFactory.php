<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected static ?string $pin;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => round(microtime(true) * 1000),
            'phone' => fake()->unique()->phoneNumber(),
            'phone_verified_at' => round(microtime(true) * 1000),
            'username' => fake()->unique()->userName(),
//            'password' => static::$password ??= password_hash('password', PASSWORD_ARGON2ID),
//            'pin' => static::$pin ??= password_hash('123456', PASSWORD_ARGON2ID),
            'password' => static::$password ??= Hash::make('password'),
            'pin' => static::$pin ??= Hash::make('123456'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'phone_verified_at' => null,
        ]);
    }
}
