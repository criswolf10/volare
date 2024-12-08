<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aircraft;

class AircraftSeeder extends Seeder
{
    public function run()
    {
        // Generar 10 aviones de prueba
        Aircraft::factory()->count(10)->create();
    }
}
