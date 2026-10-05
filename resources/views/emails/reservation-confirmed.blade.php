<x-mail::message>
# Rezervacija primljena

Poštovani {{ $reservation->guestDisplayName() }},

Vaša rezervacija za događaj **{{ $reservation->event->name }}** je zaprimljena i nalazi se **na čekanju**. Javit ćemo Vam se kada je potvrdimo.

**Detalji rezervacije:**
- Stol: {{ $reservation->table->name }}
- Broj osoba: {{ $reservation->num_people }}
- Datum događaja: {{ $reservation->event->date->format('d.m.Y H:i') }}
- Status: {{ $reservation->statusLabel() }}
@if($reservation->notes)
- Napomena: {{ $reservation->notes }}
@endif

Napomena: uz rezervaciju je obavezna boca pića.

<x-mail::button :url="route('event.detail', $reservation->event)">
Pogledaj događaj
</x-mail::button>

Srdačan pozdrav,<br>
{{ config('app.name') }}
</x-mail::message>
