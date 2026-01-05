<h2>Podsjetnik za događaj</h2>

<p>
    Poštovani,<br><br>
    Podsjećamo Vas da danas imate rezervaciju za događaj:
</p>

<p>
    <strong>{{ $event->title }}</strong><br>
    Datum: {{ \Carbon\Carbon::parse($event->event_date)->format('d.m.Y') }}
</p>

<p>
    Radujemo se Vašem dolasku!<br><br>
    Nova priča
</p>