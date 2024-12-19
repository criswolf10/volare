<?php

namespace App\Mail;

use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FlightUpdatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $flight;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  Flight  $flight
     * @param  User  $user
     * @return void
     */
    public function __construct(Flight $flight, $user)
    {
        $this->flight = $flight;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cambio de Fecha y Hora de tu Vuelo')
                    ->view('emails.flight_updated')
                    ->with([
                        'flight' => $this->flight,
                        'user' => $this->user,
                    ]);
    }
}
