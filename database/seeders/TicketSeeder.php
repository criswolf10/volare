<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Flight;
use App\Models\Aircraft;
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
            // Obtener todos los asientos disponibles del avión del vuelo
            $availableSeats = AircraftSeat::where('aircraft_id', $flight->aircraft_id)
                ->where('reserved', false)
                ->get();

            if ($availableSeats->isEmpty()) continue;

            // Determinar aleatoriamente cuántos asientos se venderán
            $totalSeats = $availableSeats->count();
            $seatsToSell = $this->determineSeatsToSell($totalSeats); // Determina cuántos se venderán

            foreach (range(1, $seatsToSell) as $i) {
                $seat = $availableSeats->shift();
                if (!$seat) break;

                // Crear pasajeros en funcion de los asientos vendidos
                $passenger = Passenger::factory()->create();    

                // Crear el ticket
                Ticket::create([
                    'user_id' => $users->random()->id, // Usuario comprador
                    'passenger_id' => $passenger->id, // Pasajero asociado
                    'flight_id' => $flight->id,
                    'aircraft_seat_id' => $seat->id,
                    'booking_code' => strtoupper(uniqid('TKT')),
                    'quantity' => 1,
                    'purchase_date' => now(),
                ]);

                // Marcar asiento como reservado
                $seat->update(['reserved' => true]);
            }

            // Actualizar el estado del avión según los asientos vendidos
            $this->updateAircraftStatus($flight->aircraft_id);
        }
    }

    /**
     * Determina cuántos asientos vender para un vuelo.
     *
     * @param int $totalSeats
     * @return int
     */
    private function determineSeatsToSell(int $totalSeats): int
    {
        // Generar un porcentaje aleatorio de asientos vendidos
        $percentageSold = [0, 25, 50, 100][array_rand([0, 25, 50, 100])];
        return (int) round(($percentageSold / 100) * $totalSeats);
    }

    /**
     * Actualiza el estado del avión según los asientos reservados.
     *
     * @param int $aircraftId
     * @return void
     */
    private function updateAircraftStatus(int $aircraftId): void
    {
        $aircraft = Aircraft::find($aircraftId);
        $totalSeats = AircraftSeat::where('aircraft_id', $aircraftId)->count();
        $reservedSeats = AircraftSeat::where('aircraft_id', $aircraftId)
            ->where('reserved', true)
            ->count();

        if ($reservedSeats === 0) {
            $aircraft->update(['status' => 'en espera']); // Avión sin tickets vendidos
        } elseif ($reservedSeats < $totalSeats) {
            $aircraft->update(['status' => 'en espera']); // Avión parcialmente vendido
        } else {
            $aircraft->update(['status' => 'completo']); // Avión con todos los tickets vendidos
        }
    }
}
