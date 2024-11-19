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
        'code' => $this->faker->digi,
            'aircraft' => '737 MAX',
            'origin' => 'Sevilla',
            'destination' => 'Madrid',
            'duration' => '1h 33min',
            'price' => 114,
            'seats' => '1º, 2º, turist',
            'date' => '2022-10-19',
            'status' => $this->faker->randomElement(['borrador', 'en espera', 'completo', 'en trayecto']),
        ];
    }
}
