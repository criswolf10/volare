<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    public function run()
    {
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
}
