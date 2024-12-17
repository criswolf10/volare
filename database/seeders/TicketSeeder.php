<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Flight;
use App\Models\AircraftSeat;
use App\Models\Passenger;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $flights = Flight::all();

        foreach ($flights as $flight) {
            $availableSeats = AircraftSeat::where('aircraft_id', $flight->aircraft_id)
                ->where('reserved', false)
                ->get();

            if ($availableSeats->isEmpty()) continue;

            // Generar tickets para 2-5 asientos por vuelo
            foreach (range(1, rand(2, 5)) as $i) {
                $seat = $availableSeats->shift();
                if (!$seat) break;

                // Obtener un pasajero aleatorio o crearlo
                $passenger = Passenger::inRandomOrder()->first() ?? Passenger::factory()->create();

                // Crear el ticket
                Ticket::create([
                    'user_id' => $users->random()->id,      // Usuario que compra el ticket
                    'passenger_id' => $passenger->id,      // Pasajero asociado
                    'flight_id' => $flight->id,
                    'aircraft_seat_id' => $seat->id,
                    'booking_code' => strtoupper(uniqid('TKT')),
                    'quantity' => 1,
                    'purchase_date' => now(),
                ]);

                // Marcar asiento como reservado
                $seat->update(['reserved' => true]);
            }
        }
    }
}
