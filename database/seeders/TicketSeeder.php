<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\User;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $flights = Flight::all(); // Obtener todos los vuelos

        foreach ($flights as $flight) {
            // Obtener el avión asociado al vuelo
            $aircraft = $flight->aircraft;

            if (!$aircraft) {
                // Si el vuelo no tiene avión asignado, lo ignoramos
                continue;
            }

            // Obtener la capacidad del avión (número de asientos)
            $totalSeats = $aircraft->capacity;

            for ($i = 0; $i < $totalSeats; $i++) {
                // Asignar un usuario aleatorio para el ticket
                $user = User::inRandomOrder()->first();

                // Asignar un precio fijo o aleatorio para el ticket
                //$price = 100.00;  // Precio fijo en euros
                $price = rand(50, 500);

                // Crear el ticket
                Ticket::create([
                    'user_id' => $user->id,
                    'flight_id' => $flight->id,
                    'price' => $price,
                    'purchase_date' => Carbon::now()->toDateString(),
                    'quantity' => 1,
                ]);
            }
        }
    }
}
