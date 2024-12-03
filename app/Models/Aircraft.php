<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    use HasFactory;

    protected $table = 'aircrafts'; // Asegúrate de que sea 'aircrafts' (en plural)

    protected $fillable = ['name', 'code', 'capacity', 'seat_classes', 'seat_codes'];

    protected $casts = [
        'seat_classes' => 'array',
        'seat_codes' => 'array',
    ];

    // Relación con vuelos
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
