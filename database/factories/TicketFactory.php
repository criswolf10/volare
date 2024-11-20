<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Flight;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    // Lista de asientos posibles
    private static $seatNumbers = [];

    public function definition()
    {
        // Generar la lista de asientos una única vez
        if (empty(self::$seatNumbers)) {
            foreach (range('A', 'F') as $row) {
                foreach (range(1, 60) as $seat) {
                    self::$seatNumbers[] = $row . $seat;
                }
            }
            shuffle(self::$seatNumbers); // Mezclar los asientos para mayor aleatoriedad
        }

        // Tomar un asiento único de la lista
        $seatNumber = array_pop(self::$seatNumbers);

        return [
            'user_id' => $this->faker->optional()->randomElement(User::pluck('id')->toArray()), // Puede ser null o un usuario
            'flight_id' => Flight::inRandomOrder()->first()->id, // Asociado a un vuelo siempre
            'quantity' => $this->faker->numberBetween(1, 100),
            'seat_number' => $this->faker->unique()->regexify($seatNumber), // Asegura unicidad
        ];
    }
}
