<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use App\Models\AircraftSeat;
use Illuminate\Database\Seeder;

class AircraftSeeder extends Seeder
{
    public function run()
    {
        // Crear 8 aviones con diferentes capacidades
        $capacities = [120, 180, 240];
        foreach (range(1, 8) as $index) {
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

        for ($i = 1; $i <= $rows; $i++) {
            $class = $i <= 3 ? '1ª clase' : ($i <= 8 ? '2ª clase' : 'turista');
            foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $letter) {
                AircraftSeat::create([
                    'aircraft_id' => $aircraft->id,
                    'class' => $class,
                    'seat_code' => $letter . $i,
                    'price' => $class === '1ª clase' ? 150 : ($class === '2ª clase' ? 100 : 50),
                    'reserved' => false,
                ]);
            }
        }
    }
}
