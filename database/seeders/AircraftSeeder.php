<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aircraft;

class AircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usando el factory para generar 6 aviones
        Aircraft::factory()->count(10)->create();
    }
}
