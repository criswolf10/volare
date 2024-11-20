<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Flight;
use App\Models\User;

class TicketSeeder extends Seeder
{
    public function run()
    {

        $users = User::all();
        $flights = Flight::all();

        // Crear tickets con usuario asignado
        foreach ($users as $user) {
            Ticket::factory()->create([
                'user_id' => $user->id,
                'flight_id' => $flights->random()->id,
            ]);
        }

        // Crear tickets sin usuario asignado
        Ticket::factory(100)->create([
            'user_id' => null, // Billetes no comprados
            'flight_id' => $flights->random()->id,
        ]);
    }
}
