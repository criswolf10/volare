<?php

namespace Database\Factories;

use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    /**
     * Define the model's default state.
     */public function definition(): array
{
    // Generar una duración válida en formato "hh:mm:ss"
    $hours = $this->faker->numberBetween(0, 12); // Hasta 12 horas
    $minutes = $this->faker->numberBetween(35, 59); // Mínimo 35 minutos

    return [
        'code' => $this->faker->regexify('[A-Z][0-9]{3}[A-Z]'),
        'aircraft' => $this->faker->regexify('[0-9]{3} [A-Z]{3}'),
        'origin' => $this->faker->city,
        'destination' => $this->faker->city,
        'duration' => sprintf('%02d:%02d:00', $hours, $minutes), // Duración en formato válido
        'departure_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
        'departure_time' => $this->faker->time('H:i'),
        'arrival_time' => $this->faker->time('H:i'),
        'seats_quantity' => 180,  // Fijado en 180
        'seats_class' => $this->faker->randomElement(['1ª clase', '2ª clase', 'turista']),
        'seats_code' => $this->generateSeatCode(),  // Asignar código de asiento
        'status' => $this->faker->randomElement(['borrador', 'en espera', 'en trayecto', 'completo', 'cancelado']),
    ];
}

/**
 * Método para generar un código de asiento (A1 a F30)
 */
private function generateSeatCode()
{
    // Las letras para los asientos (A-F)
    $letters = ['A', 'B', 'C', 'D', 'E', 'F'];

    // Escoge una letra aleatoria (de A a F)
    $letter = $this->faker->randomElement($letters);

    // Escoge un número de fila aleatorio (del 1 al 30)
    $number = $this->faker->numberBetween(1, 30);

    // Devuelve el código de asiento como "A1", "B2", etc.
    return "{$letter}{$number}";
}

}
