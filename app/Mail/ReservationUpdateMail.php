<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationUpdateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
    }

    public function envelope(): Envelope
    {
        $subject = $this->reservation->status === Reservation::STATUS_CANCELLED
            ? 'Rezervacija otkazana – '
            : 'Rezervacija ažurirana – ';

        return new Envelope(
            subject: $subject . $this->reservation->event->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reservation-updated',
        );
    }
}
