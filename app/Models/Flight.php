<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
    protected $fillable = ['code', 'origin', 'destination', 'duration', 'departure_date', 'departure_time', 'arrival_time', 'status'];



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
        return $this->hasMany(Ticket::class );
    }

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

public function registerMediaCollections(): void
{
    $this->addMediaCollection('flight_images')->useDisk('public')->singleFile(); // Almacena solo una imagen
}

}
