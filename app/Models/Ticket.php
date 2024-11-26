<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'flight_code',
        'price',
        'purchase_date',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2', // Formato decimal con 2 decimales
        'purchase_date' => 'date', // Fecha como instancia de Carbon
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
        return $this->belongsTo(Flight::class, 'flight_code', 'code');
    }
}
