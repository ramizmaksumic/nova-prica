@component('mail::message')
# Izbrisana rezervacija

Korisnik **{{ $reservation->user->name }}** je izbrisao svoju rezervaciju.

**Detalji:**
- Događaj: {{ $reservation->event->name }}
- Stol: {{ $reservation->table->name }}
- Broj osoba: {{ $reservation->num_people }}
- Napomena: {{ $reservation->notes ?? 'Nema napomene' }}
- Datum: {{ $reservation->event->date->format('d.m.Y H:i') }}



Hvala,
**Sistem rezervacija**
@endcomponent