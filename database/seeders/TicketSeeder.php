<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Flight;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{

    public function run()
    {
        // Genera tickets para un usuario aleatorio y un vuelo aleatorio
        Ticket::factory()->count(200)->create(); // Esto generará un ticket (o 4 como configuraste en el factory)
    }

}
