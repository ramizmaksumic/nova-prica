<?php

namespace App\Http\Controllers;

use App\Mail\ReservationConfirmedMail;
use App\Mail\ReservationUpdateMail;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function __construct(private ReservationService $reservations)
    {
    }

    /**
     * Rezervacija se pravi sa stranice događaja (mapa stolova), pa ova ruta vodi na listu događaja.
     */
    public function create()
    {
        return redirect()->route('events');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'table_id' => 'required|integer|exists:tables,id',
            'num_people' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:255',
        ]);

        $reservation = $this->reservations->create($validated + ['user_id' => Auth::id()]);

        Mail::to($reservation->user->email)
            ->cc(config('mail.admin_email'))
            ->queue(new ReservationConfirmedMail($reservation));

        return redirect()->back()->with('success', 'Rezervacija je uspješno kreirana i nalazi se na čekanju. Povratne informacije od administratora će vam doći na email. Hvala.');
    }

    public function edit(Reservation $reservation)
    {
        Gate::authorize('update', $reservation);

        $reservation->load('table:id,name,min_capacity,max_capacity');

        return view('reservation.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        Gate::authorize('update', $reservation);

        $validated = $request->validate([
            'num_people' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:255',
        ]);

        $reservation->load('table');
        $this->reservations->ensureCapacity($reservation->table, (int) $validated['num_people']);

        $reservation->update($validated);

        Mail::to($reservation->user->email)
            ->cc(config('mail.admin_email'))
            ->queue(new ReservationUpdateMail($reservation));

        return redirect()->route('profile.index')->with('success', 'Rezervacija uspješno ažurirana.');
    }

    /**
     * Korisnik otkazuje rezervaciju. Zapis ostaje (status "cancelled") da admin vidi otkazivanja,
     * a stol se odmah oslobađa.
     */
    public function destroy(Reservation $reservation)
    {
        Gate::authorize('delete', $reservation);

        $reservation->update(['status' => Reservation::STATUS_CANCELLED]);

        Mail::to($reservation->user->email)
            ->cc(config('mail.admin_email'))
            ->queue(new ReservationUpdateMail($reservation));

        return back()->with('success', 'Rezervacija je otkazana.');
    }
}
