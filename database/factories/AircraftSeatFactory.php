<?php

namespace Database\Factories;

use App\Models\Aircraft;
use App\Models\AircraftSeat;
use Illuminate\Database\Eloquent\Factories\Factory;

class AircraftSeatFactory extends Factory
{
    protected $model = AircraftSeat::class;

    public function definition(): array
    {
        return [
            'aircraft_id' => Aircraft::factory(), // Relacionado con un avión
            'class' => 'turista', // Placeholder
            'seat_code' => 'A1', // Placeholder
            'price' => 0, // Se sobrescribirá
            'reserved' => false, // Asientos no reservados por defecto
        ];
    }

    /**
     * Genera los asientos del avión con precios según la clase.
     */
    public function configureSeats(Aircraft $aircraft)
    {
        $capacity = $aircraft->capacity;
        $rows = $capacity / 6; // 6 asientos por fila
        $seatLetters = ['A', 'B', 'C', 'D', 'E', 'F'];

        // Define las clases y sus precios
        $classPrices = [
            '1ª clase' => 150,
            '2ª clase' => 100,
            'turista' => 50,
        ];

        // Define las clases por filas
        $firstClassRows = 3; // 1ª clase: primeras 3 filas
        $secondClassRows = 5; // 2ª clase: siguientes 5 filas
        $touristRows = $rows - ($firstClassRows + $secondClassRows);

        $seats = [];

        for ($row = 1; $row <= $rows; $row++) {
            // Determinar clase del asiento
            if ($row <= $firstClassRows) {
                $seatClass = '1ª clase';
            } elseif ($row <= ($firstClassRows + $secondClassRows)) {
                $seatClass = '2ª clase';
            } else {
                $seatClass = 'turista';
            }

            // Obtener precio según la clase
            $price = $classPrices[$seatClass];

            // Crear los asientos de la fila
            foreach ($seatLetters as $letter) {
                $seats[] = [
                    'aircraft_id' => $aircraft->id,
                    'class' => $seatClass,
                    'seat_code' => $letter . $row,
                    'price' => $price,
                    'reserved' => false,
                ];
            }
        }

        // Insertar los asientos en la base de datos
        AircraftSeat::insert($seats);
    }
}
