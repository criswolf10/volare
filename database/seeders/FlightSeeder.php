<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use Database\Factories\FlightFactory;

class FlightSeeder extends Seeder
{
    public function run()
    {
        Flight::factory(45)->create();
    }
}

