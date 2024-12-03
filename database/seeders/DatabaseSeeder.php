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
        // Llamar al UserSeeder para gestionar la creación de usuarios y asignación de roles
        $this->call([
            UserSeeder::class,
        ]);

        // Llamar a los seeders de vuelos, ventas y tickets
        $this->call([
            FlightSeeder::class,
            TicketSeeder::class,
            AircraftSeeder::class,
        ]);
    }
}
