<p>Vasa rezevacija je primljena.</p>

@component('mail::message')
# Potvrda rezervacije

Poštovani {{ $reservation->user->name }},

Vaša rezervacija za događaj **{{ $reservation->event->name }}** je uspješno kreirana.

**Detalji rezervacije:**
- Stol: {{ $reservation->table->name }}
- Broj osoba: {{ $reservation->num_people }}
- Datum događaja: {{ $reservation->event->date->format('d.m.Y H:i') }}
- Status: {{ ucfirst($reservation->status) }}
- Dodatna napomena: {{ ucfirst($reservation->notes) }}

@component('mail::button', ['url' => route('event.detail', $reservation->event->id)])
Pogledaj događaj
@endcomponent

Hvala što koristite naš sistem rezervacija!
Srdačan pozdrav,
**Vaš tim iz restorana**
@endcomponent