<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->regexify('[A-Z]{1}[1-9]{3}[A-Z]{1} '), // codigo de vuelo con formato A999A
            'origin' => $this->faker->city(), // Nombre de la ciudad de origen
            'destination' => $this->faker->city(), // Nombre de la ciudad de destino
            'duration' => $this->faker->time('H:i:s'), // Duración del vuelo en formato hh:mm:ss
            'departure_date' => $this->faker->date('Y-m-d', 'now +1 year'), // Fecha de salida
            'departure_time' => $this->faker->time('H:i:s'), // Hora de salida
            'arrival_time' => $this->faker->time('H:i:s'), // Hora de llegada
            'aircraft_id' => Aircraft::factory(), // Relación con un avión
        ];
    }
}
