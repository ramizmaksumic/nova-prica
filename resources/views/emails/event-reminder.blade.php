<x-mail::message>
# Vidimo se večeras!

Poštovani {{ $reservation->guestDisplayName() }},

Podsjećamo Vas da imate potvrđenu rezervaciju za događaj:

**{{ $reservation->event->name }}**<br>
{{ $reservation->event->date->format('d.m.Y') }} u {{ $reservation->event->date->format('H:i') }}<br>
Stol: {{ $reservation->table->name }} · Broj osoba: {{ $reservation->num_people }}

Ako ne možete doći, molimo otkažite rezervaciju na svom profilu kako bi stol mogao dobiti neko drugi.

<x-mail::button :url="route('profile.index')">
Moje rezervacije
</x-mail::button>

Radujemo se Vašem dolasku!<br>
{{ config('app.name') }}
</x-mail::message>
