<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Flight;
use App\Models\User;
use Database\Factories\TicketFactory;

class TicketSeeder extends Seeder
{
    public function run()
    {
        // Asegúrate de tener usuarios en la base de datos
        $users = User::all();
        $flights = Flight::all();

        foreach ($users as $user) {
            Ticket::factory(2)->create([
                'user_id' => $user->id,
                'flight_id' => $flights->random()->id,
            ]);
        }
    }
}

