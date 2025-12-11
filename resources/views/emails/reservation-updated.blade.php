<p>Vasa rezevacija je ažurirana.</p>

@component('mail::message')
# Rezervacija ažurirana

Poštovani {{ $reservation->user->name }},

Vaša rezervacija za događaj **{{ $reservation->event->name }}** je ažurirana.

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