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
    protected $fillable = ['name', 'capacity', 'seats', 'status'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'seats' => 'array',  // Convertir la distribución de los asientos desde JSON a un array
    ];

    /**
     * Relación con vuelos.
     * Un avión puede tener muchos vuelos asociados.
     */
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
