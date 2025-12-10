<div class="space-y-8">
    <div class="flex justify-between">
        <h2 class="font-heading text-2xl font-bold text-gray-800">Rezervacije</h2>
        <button
            wire:click="$dispatch('openModal', { component: 'admin.reservation-create' })"

            class="font-heading bg-secondary rounded-md px-4 py-3 text-white">
            Kreiraj novu rezervaciju
        </button>

    </div>
    <div>
        <input type="text" wire:model.live="search"
            placeholder="Unesite događaj za pretragu..."
            class="font-heading text-slate-400 w-full rounded-md">
    </div>

    <div class="flex justify-between items-center">
        <p>Pretraženo: {{ $search }}</p>
        <button
            wire:click="downloadPdf"
            class="bg-secondary text-white px-4 py-2 rounded mb-4 hover:bg-primary/80 transition">
            Preuzmi kompletnu listu PDF
        </button>


    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
            <tr>
                <th class="py-3 px-6 text-left">Ime</th>
                <th class="py-3 px-6 text-left">Prezime</th>
                <th class="py-3 px-6 text-left">Naziv</th>
                <th class="py-3 px-6 text-left">Datum</th>
                <th class="py-3 px-6 text-left">Stol</th>
                <th class="py-3 px-6 text-left">Napomena</th>
                <th class="py-3 px-6 text-left">Broj osoba</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Telefon</th>
                <th class="py-3 px-6 text-left">Status</th>
                <th class="py-3 px-6 text-center">Akcija</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-6">{{ $reservation->user->name }}</td>
                <td class="py-3 px-6">{{ $reservation->user->surname }}</td>
                <td class="py-3 px-6">{{ $reservation->event->name }}</td>
                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($reservation->event->date)->format('d/m/Y') }}</td>
                <td class="py-3 px-6">{{ $reservation->table->name }}</td>
                <td class="py-3 px-6">{{$reservation->notes }}</td>
                <td class="py-3 px-6">{{$reservation->num_people }}</td>
                <td class="py-3 px-6">{{$reservation->user->email }}</td>
                <td class="py-3 px-6">{{$reservation->user->phone }}</td>
                <td class="py-3 px-6">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $reservation->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($reservation->status) }}
                    </span>
                </td>
                <td class="py-3 px-6 text-center">
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.reservation-update', arguments: { reservationId: {{ $reservation->id }} } })"
                        class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.reservation-delete', arguments: { reservationId: {{ $reservation->id }} } })"
                        class="text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $reservations->links() }}
    </div>
</div>