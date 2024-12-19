<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aircraft;
use App\Models\AircraftSeat;
use App\Models\Flight;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Passenger;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;

class SimulateSoldTicketsSeeder extends Seeder
{

    public function run()
    {
        // Crear un avión
        $aircraft = Aircraft::create([
            'name' => 'Boeing 744',
            'capacity' => 180,
            'status' => 'borrador',
        ]);

        // Verificar que el avión se creó correctamente
        if (is_null($aircraft->id)) {
            throw new Exception('El avión no se creó correctamente.');
        }

        // Crear un vuelo asociado al avión
        $flight = Flight::create([
            'id' => 29, // Asignar un ID específico para evitar duplicados
            'code' => 'F123K', // Cambiar el código si necesitas evitar duplicados
            'origin' => 'Sevilla',
            'destination' => 'Madrid',
            'departure_date' => Carbon::today()->addDays(1)->format('Y-m-d'),
            'departure_time' => '14:00:00',
            'arrival_time' => '15:30:00',
            'duration' => '01:30:00',
            'aircraft_id' => $aircraft->id, // Asociar el vuelo al avión
        ]);

        // Verificar que el vuelo se creó correctamente
        if (is_null($flight->id)) {
            throw new Exception('El vuelo no tiene un ID válido.');
        }

        // Crear usuarios ficticios
        $users = User::factory(50)->create();

        // Crear asientos del avión
        $seats = [];
        foreach (range(1, $aircraft->capacity) as $i) {
            $seats[] = AircraftSeat::create([
                'aircraft_id' => $aircraft->id, // Relacionar asiento con avión
                'seat_code' => 'S' . $i, // Código del asiento
                'class' => ['1ª clase', '2ª clase', 'turista'][array_rand(['1ª clase', '2ª clase', 'turista'])],
                'price' => rand(50, 150),
            ]);
        }

        // Crear pasajeros y tickets
        foreach ($seats as $i => $seat) {
            $user = $users->random(); // Seleccionar un usuario aleatorio
            $seat->update(['reserved' => true]);
            $passenger = Passenger::create([
                'name' => 'Pasajero ' . ($i + 1),
                'lastname' => 'Apellido ' . ($i + 1),
                'email' => 'passenger' . ($i + 1) . '@example.com',
                'phone' => '123456789',
                'dni' => '12345678' . ($i + 1),
            ]);

            Ticket::create([
                'flight_id' => $flight->id, // Asociar el ticket al vuelo
                'aircraft_seat_id' => $seat->id, // Asociar el ticket al asiento
                'passenger_id' => $passenger->id, // Asociar el ticket al pasajero
                'user_id' => $user->id, // Asociar el ticket al usuario
                'quantity' => 1,
                'purchase_date' => Carbon::now(),
                'booking_code' => 'TKT' . strtoupper(Str::random(10)), // Generar código único
            ]);
        }

        // Cargar la relación entre avión y asientos
        $aircraft->load('seats');

        // Actualizar el estado del avión a "completo" si todos los asientos están ocupados
        if ($aircraft->seats->where('reserved', true)->count() >= $aircraft->capacity) {
            $aircraft->update(['status' => 'completo']);
        }
    }
}
