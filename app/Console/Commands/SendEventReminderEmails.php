<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Mail\EventReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\SendEventReminderJob;

class SendEventReminderEmails extends Command
{
    protected $signature = 'events:send-reminders';
    protected $description = 'Slanje automatski mailova kao podsjetnik za događaje';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $events = Event::whereBetween('date', [
            now()->startOfDay(),
            now()->endOfDay(),
        ])
            ->where('reminder_sent', false)
            ->get();


        foreach ($events as $event) {
            foreach ($event->reservations as $reservation) {
                SendEventReminderJob::dispatch($event, $reservation);
            }

            // označimo da je reminder poslan
            $event->update([
                'reminder_sent' => true,
            ]);
        }

        $this->info('Podsjetnik je uspješno poslan.');
    }
}
