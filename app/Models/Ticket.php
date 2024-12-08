<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
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
        'user_id',
        'flight_id',
        'booking_code',
        'price',
        'purchase_date',
        'seat',
        'quantity',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'purchase_date' => 'datetime', // La fecha se convertirá a una instancia de Carbon
        'seat' => 'array',  // Los asientos se almacenarán como un array
    ];

    /**
     * Relación con el modelo `User`.
     *
     * Un ticket pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
     * Validar que un asiento único no pueda estar asignado dos veces en el mismo vuelo.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $exists = Ticket::where('flight_id', $ticket->flight_id)
                ->where('seat', $ticket->seat)
                ->exists();

            if ($exists) {
                throw new \Exception("El asiento {$ticket->seat} ya está asignado en el vuelo {$ticket->flight_id}");
            }
        });
    }
}
