<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Ruta a tu imagen predeterminada
        $defaultImagePath = public_path('img/avatar.png');

        return [
            'name' => fake()->name(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => $this->generateFormattedPhoneNumber(),  // Usar la función para formatear el teléfono
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Función para generar el número de teléfono formateado.
     *
     * @return string
     */
    protected function generateFormattedPhoneNumber(): string
    {
        // Generar un número de teléfono aleatorio
        $phone = fake()->phoneNumber();

        // Eliminar cualquier caracter no numérico
        $phone = preg_replace('/\D/', '', $phone);

        // Asegurarse de que el teléfono tenga al menos 9 dígitos
        $phone = substr($phone, 0, 9);

        // Formatear el teléfono en el formato 'xxx xxx xxx'
        return substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 3);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

