<?php

namespace Database\Factories;

use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
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
            'seats_class' => $this->faker->randomElement(['1ª clase', '2ª clase', 'turista']),
            'status' => $this->faker->randomElement(['cancelado', 'en espera', 'en trayecto', 'completo']),
        ];
    }
}
