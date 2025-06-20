<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\flight;

class FlightCancelled extends Mailable
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
    public function __construct(flight $flight, $user)
    {
        $this->flight = $flight;
        $this->user = $user;
    }


    public function build()
    {
        return $this->subject('Your flight has been cancelled')
                    ->view('emails.flight-cancelled')
                    ->with([
                        'flight' => $this->flight,
                        'user' => $this->user,
                    ]);
    }
}
