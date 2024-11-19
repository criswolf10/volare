<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'quantity' => 2, // Cantidad fija en 2
            'seat_number' => $this->faker->randomElement(['24A', '24B']), 
        ];
    }
}
