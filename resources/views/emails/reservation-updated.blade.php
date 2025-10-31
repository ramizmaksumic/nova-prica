@component('mail::message')
# Ažurirana rezervacija

Korisnik **{{ $reservation->user->name }}** je ažurirao svoju rezervaciju.

**Detalji:**
- Događaj: {{ $reservation->event->name }}
- Stol: {{ $reservation->table->name }}
- Broj osoba: {{ $reservation->num_people }}
- Napomena: {{ $reservation->notes ?? 'Nema napomene' }}
- Datum: {{ $reservation->event->date->format('d.m.Y H:i') }}

@component('mail::button', ['url' => route('dashboard')])
Otvori dashboard
@endcomponent

Hvala,
**Sistem rezervacija**
@endcomponent