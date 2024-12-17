<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Flight;
use App\Models\AircraftSeat;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        // Obtener un usuario aleatorio o crearlo
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // Obtener un vuelo aleatorio o crearlo
        $flight = Flight::inRandomOrder()->first() ?? Flight::factory()->create();

        // Obtener un asiento no reservado
        $seat = AircraftSeat::where('reserved', false)
            ->where('aircraft_id', $flight->aircraft_id)
            ->inRandomOrder()
            ->first();

        if (!$seat) {
            throw new \Exception("No hay asientos disponibles para el vuelo {$flight->id}");
        }

        // Marcar el asiento como reservado
        $seat->update(['reserved' => true]);

        // Obtener un pasajero aleatorio o crearlo
        $passenger = Passenger::inRandomOrder()->first() ?? Passenger::factory()->create();

        return [
            'user_id' => $user->id,
            'passenger_id' => $passenger->id, // Asociamos el ticket al pasajero
            'flight_id' => $flight->id,
            'aircraft_seat_id' => $seat->id,
            'booking_code' => strtoupper(Str::random(10)),
            'quantity' => 1,
            'purchase_date' => now(),
        ];
    }
}
