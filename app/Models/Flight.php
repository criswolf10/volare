<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'flights';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code'; // Clave primaria personalizada

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false; // Desactivar incremento automático

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string'; // Tipo de dato de la clave primaria

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'aircraft_id', 'origin', 'destination', 'duration', 'departure_date', 'departure_time', 'arrival_time', 'status'];



    /**
     * Asigna un asiento al ticket y actualiza la disponibilidad.
     *
     * @param string $class Clase del asiento (first_class, second_class, tourist).
     * @return string|null Código del asiento asignado o null si no hay disponibles.
     */

    /**
     * Relación con los tickets.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'flight_code', 'code');
    }

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }
}
