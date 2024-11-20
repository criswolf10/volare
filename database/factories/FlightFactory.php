<?php

namespace Database\Factories;

use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;


class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition()
    {
        return [
            // Código: Letra (A-Z) + 3 dígitos + Letra (A-Z)
            'code' => $this->faker->unique()->regexify('[A-Z][0-9]{3}[A-Z]'),

            // Aeronave: 3 dígitos + 3 letras (A-Z)
            'aircraft' => $this->faker->regexify('[0-9]{3} [A-Z]{3}'),

            // Origen: Ciudad aleatoria
            'origin' => $this->faker->city(),

            // Destino: Ciudad aleatoria diferente al origen
            'destination' => $this->faker->city(),

            // Duración: Horas y/o minutos
            'duration' => $this->faker->randomElement([
                $this->faker->numberBetween(1, 12) . ' horas',
                $this->faker->numberBetween(1, 59) . ' minutos',
                $this->faker->numberBetween(1, 12) . ' horas y ' . $this->faker->numberBetween(11, 59) . ' minutos',
            ]),

            // Precio: Número entero entre 50 y 1000 (en €)
            'price' => $this->faker->numberBetween(50, 1000),

            // Clase: 1º clase, 2ª clase o turista
            'seats' => $this->faker->randomElement(['1º clase', '2º clase', 'turista']),

            // Fecha: Formato español (día/mes/año)
            'date' => $this->faker->dateTimeBetween('now','+5 months'),
            // Estado: Borrador, en espera, completo o en trayecto
            'status' => $this->faker->randomElement(['borrador', 'en espera', 'completo', 'en trayecto']),

        ];
    }
}
