<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AircraftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Generar el nombre del avión
        $name = 'Airbus ' . strtoupper($this->faker->bothify('###'));

        // Capacidad aleatoria entre las opciones especificadas
        $capacity = $this->faker->randomElement([120, 180, 240]);

        // Estado inicial: 'borrador'
        $status = 'borrador';

        return [
            'name' => $name,
            'capacity' => $capacity,
            'status' => $status,
        ];
    }
}
