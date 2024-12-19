<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use App\Models\AircraftSeat;
use App\Models\Flight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EsperaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { // Crear 8 aviones con diferentes capacidades
        $capacities = [120, 180, 240];
        foreach (range(1, 10) as $index) {
            $capacity = $capacities[array_rand($capacities)];
            $aircraft = Aircraft::factory()->create([
                'capacity' => $capacity,
                'status' => 'borrador',
            ]);

            // Generar los asientos correspondientes
            $this->generateSeats($aircraft);
        }


    $aircrafts = Aircraft::all();

    // Crear 5 vuelos
    foreach (range(1, 5) as $index) {
        $aircraft = $aircrafts->random();

        Flight::factory()->create([
            'aircraft_id' => $aircraft->id,
        ]);

        // Actualizar el estado del avión a 'en espera'
        $aircraft->update(['status' => 'en espera']);
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
