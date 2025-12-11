<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReservationConfirmedMail;
use App\Mail\ReservationDeleteMail;
use App\Mail\ReservationUpdateMail;
use Illuminate\Support\Facades\Mail;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reservation');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'table_id' => 'required|exists:tables,id',
            'num_people' => 'required|integer|min:1|max:8',
            'notes' => 'nullable|string|max:255',
        ]);

        //Provjera da li je stol već rezervisan

        $alreadyReserved = Reservation::where('event_id', $validated['event_id'])
            ->where('table_id', $validated['table_id'])
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($alreadyReserved) {
            return back()->withErrors(['table_id' => 'Ovaj stol je već rezervisan za izabrani događaj.']);
        }

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'event_id' => $validated['event_id'],
            'table_id' => $validated['table_id'],
            'num_people' => $validated['num_people'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        $table = Table::find($validated['table_id']);
        $table->update(['is_reserved' => true]);

        $reservation->load(['user', 'event', 'table']);

        // Email korisniku
        Mail::to($reservation->user->email)
            ->cc('info@novaprica.ba')
            ->queue(new ReservationConfirmedMail($reservation));






        return redirect()->back()->with('success', 'Rezervacija je uspješno kreirana i nalazi se na čekanju. Povratne informacije od administratora će vam doći na email. Hvala.');
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
    public function edit(Reservation $reservation)
    {


        return view('reservation.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'num_people' => 'required|integer|min:1|max:8',
            'notes' => 'nullable|string|max:255',
        ]);

        $reservation->update($validated);

        Mail::to(Auth::user()->email)->send(new ReservationUpdateMail($reservation));

        return redirect()->route('profile.index')->with('success', 'Rezervacija uspješno ažurirana.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        Mail::to(Auth::user()->email)->send(new ReservationDeleteMail($reservation));

        return back()->with('message', 'Rezervacija je uspješno obrisana.');
    }
}
