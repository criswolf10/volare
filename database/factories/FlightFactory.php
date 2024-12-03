<?php
namespace Database\Factories;

use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition()
    {
        // Generamos el código de vuelo en el formato A-Z, 3 dígitos, A-Z
        $code = strtoupper($this->faker->randomLetter) . $this->faker->numberBetween(100, 999) . strtoupper($this->faker->randomLetter);

        // Generamos la duración como horas y minutos (formato HH:MM)
        $durationMinutes = $this->faker->numberBetween(30, 600); // Duración de 30 minutos a 10 horas
        $hours = floor($durationMinutes / 60);
        $minutes = $durationMinutes % 60;
        $duration = sprintf('%02d:%02d', $hours, $minutes); // Formateamos a HH:MM

        // Generamos la hora de salida aleatoria
        $departureTime = Carbon::createFromFormat('H:i', $this->faker->time('H:i'));

        // Calculamos la hora de llegada sumando la duración a la hora de salida
        $arrivalTime = $departureTime->copy()->addMinutes($durationMinutes)->format('H:i');

        // Generamos los datos del vuelo
        return [
            'code' => $code,
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'duration' => $duration, // Guardamos la duración en formato HH:MM
            'departure_date' => $this->faker->date(), // Fecha aleatoria dentro del año
            'departure_time' => $departureTime->format('H:i'), // Hora aleatoria de salida
            'arrival_time' => $arrivalTime, // Hora de llegada calculada
            'status' => $this->faker->randomElement(['borrador', 'en espera', 'en trayecto', 'completo', 'cancelado']),
            'aircraft_id' => Aircraft::factory(), // Relacionamos el vuelo con un avión aleatorio
        ];
    }
}
