<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::upcoming()->get();

        return view('events', compact('events'));
    }

    public function detail(Event $event)
    {
        // Neaktivni događaji su vidljivi samo adminu (pregled prije objave).
        abort_unless($event->isActive() || auth()->user()?->isAdmin(), 404);

        $statusByTable = Reservation::where('event_id', $event->id)
            ->blocking()
            ->pluck('status', 'table_id');

        $reservedTables = $statusByTable->filter(fn ($s) => $s === Reservation::STATUS_ACTIVE)->keys()->all();
        $pendingTables = $statusByTable->filter(fn ($s) => $s === Reservation::STATUS_PENDING)->keys()->all();

        $tables = Table::orderBy('id')->get(['id', 'name', 'min_capacity', 'max_capacity', 'description']);
        $freeTables = max(0, $tables->count() - $statusByTable->count());

        $userReservation = auth()->check()
            ? Reservation::where('event_id', $event->id)->where('user_id', auth()->id())->blocking()->first()
            : null;

        session(['last_event' => $event->id]);

        return view('event-detail', [
            'event' => $event,
            'eventLink' => $event->link,
            'activeReservation' => count($reservedTables),
            'pendingReservation' => count($pendingTables),
            'freeTables' => $freeTables,
            'tables' => $tables,
            'reservedTables' => $reservedTables,
            'pendingTables' => $pendingTables,
            'userReservation' => $userReservation,
        ]);
    }
}
