<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="font-heading text-2xl text-primary font-bold">{{ $eventsCount }}</p>
        <p class="text-gray-600 mt-1">Ukupno događaja</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="font-heading text-2xl text-primary font-bold">{{ $reservationsCount }}</p>
        <p class="text-gray-600 mt-1">Ukupno rezervacija</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="font-heading text-2xl text-primary font-bold">{{ $tablesCount }}</p>
        <p class="text-gray-600 mt-1">Ukupno stolova</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="font-heading text-2xl text-primary font-bold">{{ $reservationPending }}</p>
        <p class="text-gray-600 mt-1">Rezervacija na čekanju</p>
    </div>
</div>