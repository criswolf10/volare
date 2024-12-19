<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aircraft;
use App\Models\AircraftSeat;

class BorradorSeeder extends Seeder
{
    public function run()
    {
        // Crear 4 aviones con diferentes capacidades
        $capacities = [120, 180, 240];
        foreach (range(1, 4) as $index) {
            $capacity = $capacities[array_rand($capacities)];
            $aircraft = Aircraft::factory()->create([
                'capacity' => $capacity,
                'status' => 'borrador',
            ]);

            // Generar los asientos correspondientes
            $this->generateSeats($aircraft);
        }
    }

    private function generateSeats($aircraft)
    {
        $totalSeats = $aircraft->capacity;
        $seatsPerRow = 6; // 6 asientos por fila
        $rows = $totalSeats / $seatsPerRow;

        // Crear asientos en función del total de asientos y su clase
        for ($i = 1; $i <= $rows; $i++) {
            // Determinar la clase según la fila
            $class = $i <= 3 ? '1ª clase' : ($i <= 8 ? '2ª clase' : 'turista');

            // Crear los asientos con las letras A, B, C, D, E, F para cada fila
            foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $letter) {
                AircraftSeat::create([
                    'aircraft_id' => $aircraft->id,
                    'class' => $class,
                    'seat_code' => $letter . $i,
                    'price' => $class === '1ª clase' ? 150 : ($class === '2ª clase' ? 100 : 50),
                    'reserved' => false, // Por defecto, los asientos no están reservados
                ]);
            }
        }
    }
}
