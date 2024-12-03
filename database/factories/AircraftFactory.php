<?php

namespace Database\Factories;

use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Factories\Factory;

class AircraftFactory extends Factory
{
    protected $model = Aircraft::class;

    public function definition()
    {
        // Definimos las opciones válidas para el nombre del avión
        $names = ['Boing', 'Airbus', 'Apache', 'T-rex', 'Falcon', 'Halcon', 'Condor', 'Eagle', 'Hawk', 'Sparrow'];
        // Generamos el nombre aleatoriamente de las opciones
        $name = $this->faker->randomElement($names);

        // Generamos el código del avión con 3 dígitos seguidos de una letra (mayúscula)
        $code = $this->faker->numberBetween(100, 999) . strtoupper($this->faker->randomLetter());

        $totalSeats = 180; // Capacidad total del avión
        $firstClassRows = 5;
        $secondClassRows = 8;
        $economyClassRows = 17;

        // Generamos los códigos de los asientos
        $seatCodes = $this->generateSeatCodes($firstClassRows, $secondClassRows, $economyClassRows);

        return [
            'name' => $name,
            'code' => $code, // Código con 3 dígitos y una letra mayúscula
            'capacity' => $totalSeats,
            'seat_classes' => json_encode([
                'first_class' => '1ª clase',
                'second_class' => '2ª clase',
                'economy_class' => 'turista',
            ]),
            'seat_codes' => json_encode($seatCodes),
        ];
    }

    // Genera los códigos de asiento para cada clase
    private function generateSeatCodes($firstClassRows, $secondClassRows, $economyClassRows)
    {
        $columns = ['A', 'B', 'C', 'D', 'E', 'F']; // 6 columnas por fila

        // Códigos de asiento para las clases
        $seatCodes = [
            'first_class' => [],
            'second_class' => [],
            'economy_class' => [],
        ];

        // 1ª clase
        for ($row = 1; $row <= $firstClassRows; $row++) {
            foreach ($columns as $column) {
                $seatCodes['first_class'][] = $column . $row;
            }
        }

        // 2ª clase
        for ($row = $firstClassRows + 1; $row <= $firstClassRows + $secondClassRows; $row++) {
            foreach ($columns as $column) {
                $seatCodes['second_class'][] = $column . $row;
            }
        }

        // Clase turista
        for ($row = $firstClassRows + $secondClassRows + 1; $row <= $firstClassRows + $secondClassRows + $economyClassRows; $row++) {
            foreach ($columns as $column) {
                $seatCodes['turist'][] = $column . $row;
            }
        }

        return $seatCodes;
    }
}
