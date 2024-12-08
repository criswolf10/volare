<?php

// FlightSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Ticket;

class FlightSeeder extends Seeder
{
    public function run()
    {
        // Crear vuelos con tickets asignados
        Flight::factory()
            ->count(10)
            ->create();
    }
}
