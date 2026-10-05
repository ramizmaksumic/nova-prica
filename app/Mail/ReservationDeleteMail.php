<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Šalje se nakon što je rezervacija obrisana, pa ne čuva model (ne bi se mogao učitati u queue jobu)
 * nego samo podatke potrebne za mail.
 */
class ReservationDeleteMail extends Mailable implements ShouldQueue
{
    use Queueable;

    public string $guestName;
    public string $eventName;
    public string $eventDate;
    public string $tableName;

    public function __construct(Reservation $reservation)
    {
        $this->guestName = $reservation->guestDisplayName();
        $this->eventName = $reservation->event->name;
        $this->eventDate = $reservation->event->date->format('d.m.Y H:i');
        $this->tableName = $reservation->table->name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rezervacija otkazana – ' . $this->eventName,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reservation-delete',
        );
    }
}
