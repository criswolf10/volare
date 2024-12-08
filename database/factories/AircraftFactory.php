<?php

namespace Database\Factories;

use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Factories\Factory;

class AircraftFactory extends Factory
{
    protected $model = Aircraft::class;

    public function definition(): array
    {
        // Capacidad del avión: siempre múltiplo de 6
        $capacity = $this->faker->numberBetween(102, 240);
        $capacity = $capacity - ($capacity % 6); // Asegurarse de que la capacidad sea múltiplo de 6

        // Generar distribución de asientos
        $seats = $this->generateSeats($capacity);

        return [
            'name' => $this->faker->word . ' ' . $this->faker->numberBetween(100, 999),
            'capacity' => $capacity,
            'seats' => json_encode($seats), // Guardar distribución como JSON
        ];
    }

    private function generateSeats(int $capacity): array
    {
        if ($capacity % 6 !== 0) {
            throw new \InvalidArgumentException("La capacidad debe ser un múltiplo de 6.");
        }

        $firstClassPercentage = 0.18;
        $secondClassPercentage = 0.30;
        $touristClassPercentage = 0.54;

        $firstClassSeats = round($capacity * $firstClassPercentage);
        $secondClassSeats = round($capacity * $secondClassPercentage);
        $touristSeats = $capacity - $firstClassSeats - $secondClassSeats;

        $distribution = [
            '1ª clase' => [],
            '2ª clase' => [],
            'turista' => [],
        ];

        $currentRow = 1;
        $seatClasses = [
            '1ª clase' => $firstClassSeats,
            '2ª clase' => $secondClassSeats,
            'turista' => $touristSeats,
        ];

        foreach ($seatClasses as $class => $seats) {
            for ($i = 0; $i < $seats; $i++) {
                $seatLetter = chr(65 + ($i % 6)); // Letras A-F
                $seatNumber = $currentRow;
                $distribution[$class][] = "{$seatLetter}{$seatNumber}";

                if (($i + 1) % 6 === 0) {
                    $currentRow++;
                }
            }
        }

        return $distribution;
    }
}
