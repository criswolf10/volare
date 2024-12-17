<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        // Generar el código único del vuelo
        $code = Str::upper($this->faker->randomLetter())
            . $this->faker->randomNumber(3, true)
            . Str::upper($this->faker->randomLetter());

        // Ciudades aleatorias
        $origin = $this->faker->city();
        $destination = $this->faker->city();

        // Asegurar que origen y destino sean diferentes
        while ($origin === $destination) {
            $destination = $this->faker->city();
        }

        // Fechas y horas
        $departureDate = $this->faker->dateTimeBetween('+1 day', '+1 month');
        $departureTime = $this->faker->dateTimeBetween('00:00:00', '23:59:59');
        $arrivalTime = $this->faker->dateTimeInInterval($departureTime, '+2 hours +6 hours'); // Llegada entre 2 y 6 horas después

        // Calcular duración en formato time (HH:MM:SS)
        $duration = $this->calculateDuration($departureTime, $arrivalTime);

        return [
            'aircraft_id' => Aircraft::factory(), // Relación con un avión
            'code' => $code,
            'origin' => $origin,
            'destination' => $destination,
            'departure_date' => $departureDate->format('Y-m-d'),
            'departure_time' => $departureTime->format('H:i:s'),
            'arrival_time' => $arrivalTime->format('H:i:s'),
            'duration' => $duration,
        ];
    }

    /**
     * Calcula la duración entre dos DateTime en formato 'HH:MM:SS'.
     */
    private function calculateDuration($departureTime, $arrivalTime): string
    {
        $departure = $departureTime->getTimestamp();
        $arrival = $arrivalTime->getTimestamp();

        // Si la hora de llegada es al día siguiente
        if ($arrival < $departure) {
            $arrival += 24 * 60 * 60; // Sumar 24 horas
        }

        $seconds = $arrival - $departure;

        // Formatear como 'HH:MM:SS'
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
