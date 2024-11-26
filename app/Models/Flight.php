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
    protected $fillable = [
        'code',
        'aircraft',
        'origin',
        'destination',
        'duration',
        'departure_date',
        'departure_time',
        'arrival_time',
        'seats_quantity', // Incluye si se puede modificar en masa
        'seats_class',
        'status',
    ];

    protected $casts = [
        'seats_class' => 'array', // Decodifica automáticamente a un array
    ];

    /**
     * Asigna un asiento al ticket y actualiza la disponibilidad.
     *
     * @param string $class Clase del asiento (first_class, second_class, tourist).
     * @return string|null Código del asiento asignado o null si no hay disponibles.
     */
    public function assignSeat(string $class): ?string
    {
        if (!isset($this->seats_class[$class]) || count($this->seats_class[$class]) === 0) {
            return null; // No hay asientos disponibles en esta clase
        }

        // Obtener y eliminar el primer asiento disponible
        $seat = array_shift($this->seats_class[$class]);

        // Actualizar la información en la base de datos
        $this->seats_quantity--;
        if ($this->seats_quantity === 0) {
            $this->status = 'completo';
        }

        $this->save();

        return $seat;
    }

    /**
     * Relación con los tickets.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'flight_code', 'code');
    }
}

