<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar al UserSeeder para gestionar la creación de usuarios y asignación de roles , al FlightSeeder para la creación de vuelos y al AircraftSeeder para la creación de aviones
        $this->call([
            UserSeeder::class,
            AircraftSeeder::class,
            FlightSeeder::class,
            TicketSeeder::class,

        ]);
    }
}
