<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 10 usuarios con datos variados
        User::factory(45)->create();

        // Llamar a los seeders de vuelos y ventas
        $this->call([
            FlightSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
