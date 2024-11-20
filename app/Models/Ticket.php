<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'quantity',
        'seat_number',
    ];

    /**
     * Scopes to filter tickets.
     */
    public function scopePurchased($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope to get tickets available for purchase.
     */
    public function scopeAvailable($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
