<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'tickets';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', // Esto ahora puede ser null
        'flight_id',
        'aircraft_seat_id',
        'booking_code',
        'purchase_date',
        'quantity',
        'passenger_id',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'purchase_date' => 'datetime',
    ];

    /**
     * Relación con el modelo `User`.
     *
     * Un ticket pertenece a un usuario (opcional).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo `Passenger`.
     *
     * Un ticket pertenece a un pasajero.
     */
    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }


    /**
     * Relación con el modelo `Flight`.
     *
     * Un ticket pertenece a un vuelo.
     */
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    /**
     * Relación con el modelo `AircraftSeat`.
     *
     * Un ticket pertenece a un asiento de avión.
     */
    public function seat()
    {
        return $this->belongsTo(AircraftSeat::class, 'aircraft_seat_id');
    }
}
