<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        // Precio aleatorio entre 50 y 500 euros
        $price = $this->faker->randomFloat(2, 50, 500);

        return [
            'user_id' => User::factory(), // Relación con un usuario aleatorio
            'flight_code' => Flight::all()->random()->code, // Relación con un vuelo aleatorio
            'price' => $price, // Precio con 2 decimales
            'purchase_date' => $this->faker->date(), // Fecha aleatoria de compra
        ];
    }
}

