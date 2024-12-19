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

class FlightsStatusSeeder extends Seeder
{
    public function run()
    {
        // Crear 20 aviones con diferentes estados
        foreach (range(1, 20) as $index) {
            // Definir los estados posibles
            $states = ['borrador', 'en espera', 'completo', 'en trayecto'];

            // Seleccionar un estado aleatorio para el avión
            $state = $states[array_rand($states)];

            // Crear un avión
            $aircraft = Aircraft::create([
                'name' => 'Avión ' . $index,
                'capacity' => 180,
                'status' => $state,
            ]);

            // Verificar que el avión se creó correctamente
            if (is_null($aircraft->id)) {
                throw new Exception('El avión no se creó correctamente.');
            }

            // Si el avión está en "en espera" o "en trayecto", creamos un vuelo
            $flight = null;
            if (in_array($state, ['en espera', 'en trayecto'])) {
                $flight = Flight::create([
                    'code' => 'F' . strtoupper(Str::random(4)),
                    'origin' => 'Origen ' . $index,
                    'destination' => 'Destino ' . $index,
                    'departure_date' => Carbon::today()->addDays(1)->format('Y-m-d'),
                    'departure_time' => '14:00:00',
                    'arrival_time' => '15:30:00',
                    'duration' => '01:30:00',
                    'aircraft_id' => $aircraft->id,
                ]);
            }

            // Crear asientos para el avión
            $seats = [];
            foreach (range(1, $aircraft->capacity) as $i) {
                $seats[] = AircraftSeat::create([
                    'aircraft_id' => $aircraft->id,
                    'seat_code' => 'S' . $i,
                    'class' => ['1ª clase', '2ª clase', 'turista'][array_rand(['1ª clase', '2ª clase', 'turista'])],
                    'price' => rand(50, 150),
                ]);
            }

            // Si el avión está en "en espera", vendemos algunos tickets
            if ($state == 'en espera') {
                // Crear usuarios ficticios
                $users = User::factory(5)->create();

                // Marcar algunos asientos como reservados
                $reservedSeats = collect($seats)->random(5); // Seleccionar 5 asientos aleatorios para vender

                foreach ($reservedSeats as $seat) {
                    $user = $users->random(); // Seleccionar un usuario aleatorio

                    // Crear un pasajero
                    $passenger = Passenger::create([
                        'name' => 'Pasajero ' . $seat->seat_code,
                        'lastname' => 'Apellido ' . $seat->seat_code,
                        'email' => 'passenger' . $seat->seat_code . '@example.com',
                        'phone' => '123456789',
                        'dni' => '12345678' . $seat->seat_code,
                    ]);

                    // Crear el ticket
                    Ticket::create([
                        'flight_id' => $flight->id,
                        'aircraft_seat_id' => $seat->id,
                        'passenger_id' => $passenger->id,
                        'user_id' => $user->id,
                        'quantity' => 1,
                        'purchase_date' => Carbon::now(),
                        'booking_code' => 'TKT' . strtoupper(Str::random(10)),
                    ]);

                    // Marcar el asiento como reservado
                    $seat->update(['reserved' => true]);
                }
            }

            // Si el avión está en "completo", vendemos todos los asientos
            if ($state == 'completo') {
                // Crear usuarios ficticios
                $users = User::factory(180)->create();

                // Vender todos los tickets
                foreach ($seats as $seat) {
                    $user = $users->random(); // Seleccionar un usuario aleatorio

                    // Crear un pasajero
                    $passenger = Passenger::create([
                        'name' => 'Pasajero ' . $seat->seat_code,
                        'lastname' => 'Apellido ' . $seat->seat_code,
                        'email' => 'passenger' . $seat->seat_code . '@example.com',
                        'phone' => '123456789',
                        'dni' => '12345678' . $seat->seat_code,
                    ]);

                    // Crear el ticket
                    Ticket::create([
                        'flight_id' => $flight->id,
                        'aircraft_seat_id' => $seat->id,
                        'passenger_id' => $passenger->id,
                        'user_id' => $user->id,
                        'quantity' => 1,
                        'purchase_date' => Carbon::now(),
                        'booking_code' => 'TKT' . strtoupper(Str::random(10)),
                    ]);

                    // Marcar el asiento como reservado
                    $seat->update(['reserved' => true]);
                }
            }

            // Si el avión está en "en trayecto", vendemos algunos tickets y actualizamos la fecha
            if ($state == 'en trayecto') {
                // Crear usuarios ficticios
                $users = User::factory(10)->create();

                // Vender algunos tickets
                $reservedSeats = collect($seats)->random(10); // Seleccionar 10 asientos aleatorios para vender

                foreach ($reservedSeats as $seat) {
                    $user = $users->random(); // Seleccionar un usuario aleatorio

                    // Crear un pasajero
                    $passenger = Passenger::create([
                        'name' => 'Pasajero ' . $seat->seat_code,
                        'lastname' => 'Apellido ' . $seat->seat_code,
                        'email' => 'passenger' . $seat->seat_code . '@example.com',
                        'phone' => '123456789',
                        'dni' => '12345678' . $seat->seat_code,
                    ]);

                    // Crear el ticket
                    Ticket::create([
                        'flight_id' => $flight->id,
                        'aircraft_seat_id' => $seat->id,
                        'passenger_id' => $passenger->id,
                        'user_id' => $user->id,
                        'quantity' => 1,
                        'purchase_date' => Carbon::now(),
                        'booking_code' => 'TKT' . strtoupper(Str::random(10)),
                    ]);

                    // Marcar el asiento como reservado
                    $seat->update(['reserved' => true]);
                }

                // Actualizar la fecha de salida del vuelo
                $flight->update([
                    'departure_date' => Carbon::today()->format('Y-m-d'),
                    'departure_time' => '14:00:00',
                    'arrival_time' => '15:30:00',
                ]);
            }
        }
    }
}
