<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $flight = Flight::factory()->create();
        $class = $this->faker->randomElement(['first_class', 'second_class', 'tourist']);
        $seat = $flight->assignSeat($class);

        return [
            'user_id' => User::factory(),
            'flight_code' => $flight->code,
            'price' => $this->faker->randomFloat(2, 50, 500),
            'purchase_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            
        ];
    }
}
