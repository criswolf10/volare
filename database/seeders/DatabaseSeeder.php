<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use function Symfony\Component\String\b;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar al UserSeeder para gestionar la creación de usuarios y asignación de roles , al FlightSeeder para la creación de vuelos y al AircraftSeeder para la creación de aviones
        $this->call([
            BorradorSeeder::class,
            EsperaSeeder::class,
            UserSeeder::class,
            TicketSeeder::class,

        ]);
    }
}
