<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Aircraft;
use App\Models\TicketSeat;

class Flight extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'flights';

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
    protected $fillable = ['code', 'origin', 'destination', 'departure_date', 'departure_time', 'arrival_time','duration','aircraft_id'];



    /**
     * Asigna un asiento al ticket y actualiza la disponibilidad.
     *
     * @param string $class Clase del asiento (first_class, second_class, tourist).
     * @return string|null Código del asiento asignado o null si no hay disponibles.
     */

    /**
     * Un vuelo pertenece a un avión.
     */

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    /**
     * Relación con el modelo `Ticket`.
     *
     * Un vuelo tiene muchos tickets asociados.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('flight_images')->useDisk('public')->singleFile(); // Almacena solo una imagen
    }
}
