<x-mail::message>
# Rezervacija otkazana

Poštovani {{ $guestName }},

Vaša rezervacija za događaj **{{ $eventName }}** ({{ $eventDate }}), stol {{ $tableName }}, je otkazana.

Ako mislite da je došlo do greške, kontaktirajte nas.

Srdačan pozdrav,<br>
{{ config('app.name') }}
</x-mail::message>
