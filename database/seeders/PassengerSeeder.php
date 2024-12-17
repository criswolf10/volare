<?php

namespace Database\Seeders;

use App\Models\Passenger;
use Illuminate\Database\Seeder;

class PassengerSeeder extends Seeder
{
    public function run()
    {
        // Crear 50 pasajeros ficticios
        Passenger::factory(50)->create();
    }
}
