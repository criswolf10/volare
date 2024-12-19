<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Passenger extends Model
    {
        use HasFactory;

        protected $fillable = [
            'name',
            'lastname',
            'email',
            'phone',
            'dni',
            'tickets_id'
        ];

        /**
         * Relación con el modelo Ticket.
         */
        public function tickets()
        {
            return $this->hasMany(Ticket::class);
        }
    }
