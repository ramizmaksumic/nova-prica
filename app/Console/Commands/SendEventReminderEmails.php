<?php

namespace App\Console\Commands;

use App\Mail\EventReminderMail;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventReminderEmails extends Command
{
    protected $signature = 'events:send-reminders';
    protected $description = 'Slanje podsjetnika gostima s potvrđenom rezervacijom za današnje događaje';

    public function handle()
    {
        $events = Event::active()
            ->whereBetween('date', [now()->startOfDay(), now()->endOfDay()])
            ->where('reminder_sent', false)
            ->get();

        $sent = 0;

        foreach ($events as $event) {
            $reservations = $event->reservations()
                ->where('status', Reservation::STATUS_ACTIVE)
                ->whereNotNull('user_id')
                ->get();

            foreach ($reservations as $reservation) {
                Mail::to($reservation->user->email)->queue(new EventReminderMail($reservation));
                $sent++;
            }

            $event->update(['reminder_sent' => true]);
        }

        $this->info("Podsjetnici stavljeni u red za slanje: {$sent}.");
    }
}
