<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        // Seleccionar un vuelo aleatorio
        $flight = Flight::inRandomOrder()->first();
        if (!$flight) {
            throw new \Exception('No hay vuelos disponibles.');
        }

        // Obtener los asientos ocupados en el vuelo
        $occupiedSeats = $flight->tickets->pluck('seat');
        $availableSeats = collect(json_decode($flight->aircraft->seats))->flatten()->diff($occupiedSeats);

        // Asegurarse de que hay asientos disponibles
        if ($availableSeats->isEmpty()) {
            throw new \Exception('No hay asientos disponibles en este vuelo.');
        }

        // Seleccionar un asiento aleatorio
        $seat = $availableSeats->random();

        // Obtener un usuario aleatorio
        $user = User::inRandomOrder()->first();
        if (!$user) {
            throw new \Exception('No hay usuarios disponibles.');
        }

        return [
            'flight_id' => $flight->id,
            'user_id' => $user->id,
            'booking_code' => $this->faker->unique()->regexify('[1-9]{5}[A-Z]{3} '),
            'seat' => $seat,
            'price' => $this->faker->randomFloat(2, 50, 300),
            'purchase_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'quantity' => 1,
        ];
    }

}
