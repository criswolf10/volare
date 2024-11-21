<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'flight_code',
        'price',
        'quantity',
        'purchase_date',
    ];

    /**
     * Relación con el modelo `User`.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo `Flight`.
     */
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_code', 'code');
    }
}
