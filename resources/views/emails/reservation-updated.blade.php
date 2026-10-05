<x-mail::message>
@if($reservation->status === \App\Models\Reservation::STATUS_CANCELLED)
# Rezervacija otkazana
@else
# Rezervacija ažurirana
@endif

Poštovani {{ $reservation->guestDisplayName() }},

@if($reservation->status === \App\Models\Reservation::STATUS_CANCELLED)
Vaša rezervacija za događaj **{{ $reservation->event->name }}** je otkazana.
@else
Vaša rezervacija za događaj **{{ $reservation->event->name }}** je ažurirana.
@endif

**Detalji rezervacije:**
- Stol: {{ $reservation->table->name }}
- Broj osoba: {{ $reservation->num_people }}
- Datum događaja: {{ $reservation->event->date->format('d.m.Y H:i') }}
- Status: **{{ $reservation->statusLabel() }}**
@if($reservation->notes)
- Napomena: {{ $reservation->notes }}
@endif

<x-mail::button :url="route('event.detail', $reservation->event)">
Pogledaj događaj
</x-mail::button>

Srdačan pozdrav,<br>
{{ config('app.name') }}
</x-mail::message>
