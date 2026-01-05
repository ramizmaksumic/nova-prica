<?php

namespace App\Jobs;

use App\Mail\EventReminderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event;
    public $reservation;

    public function __construct($event, $reservation)
    {
        $this->event = $event;
        $this->reservation = $reservation;
    }

    public function handle()
    {
        Mail::to($this->reservation->email)
            ->send(new EventReminderMail($this->event, $this->reservation));
    }
}
