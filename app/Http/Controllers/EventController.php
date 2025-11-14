<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $events = Event::all();
        return view('events', compact('events'));
    }

    public function detail(Event $event)
    {
        $activeReservation = Reservation::where('event_id', $event->id)
            ->where('status', 'active')
            ->count();

        $pendingReservation = Reservation::where('event_id', $event->id)
            ->where('status', 'pending')
            ->count();


        $tables = Table::all()->count();

        $freeTables = $tables - $activeReservation - $pendingReservation;

        return view('event-detail', compact('event', 'activeReservation', 'pendingReservation', 'freeTables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
