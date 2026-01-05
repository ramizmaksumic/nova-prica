<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventReminderMail extends Mailable
{
    use SerializesModels;
    public $event;
    public $reservation;

    public function __construct($event, $reservation)
    {
        $this->event = $event;
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Podsjetnik za današnji događaj')
            ->view('emails.event-reminder');
    }
}
