<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aircrafts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'capacity', 'status'];


    /**
     * Relación con vuelos.
     * Un avión puede tener muchos vuelos asociados.
     */
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    /**
     * Relación con asientos.
     * Un avión puede tener muchos asientos asociados.
     */

    public function seats()
{
    return $this->hasMany(AircraftSeat::class);
}
}
