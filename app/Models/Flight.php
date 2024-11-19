<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'aircraft', 'origin', 'destination', 'duration',
        'price', 'seats', 'date', 'status'
    ];

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
}

