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
    /**
     * Create a new message instance.
     */
    public function __construct(flight $flight)
    {
        $this->flight = $flight;
    }

    public function build()
    {
        return $this->subject('Your flight has been cancelled')
                    ->view('emails.flight-cancelled');
    }
}
