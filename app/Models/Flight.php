<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

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

    public function getFormattedPriceAttribute()
    {
        $formatter = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($this->price, 'EUR');
    }

}

