<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftSeat extends Model
{
    use HasFactory;

    // Especificamos la tabla relacionada
    protected $table = 'aircraft_seats';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'aircraft_id',
        'seat_code',
        'class',
        'price',
        'reserved',
    ];

    // Campos que se convierten automáticamente a tipos de datos en el modelo
    protected $casts = [
        'reserved' => 'boolean',
    ];

    /**
     * Relación con el avión
     */
    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }


    /**
     * Relación con los tickets
     */
    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'aircraft_seat_id');
    }


    /**
     * Verifica si el asiento está reservado
     *
     * @return bool
     */
    public function isAvailable()
    {
        return !$this->is_reserved;
    }

    /**
     * Marcar el asiento como reservado
     */
    public function reserve()
    {
        $this->is_reserved = true;
        $this->save();
    }

    /**
     * Marcar el asiento como libre
     */
    public function unreserve()
    {
        $this->is_reserved = false;
        $this->save();
    }
}
