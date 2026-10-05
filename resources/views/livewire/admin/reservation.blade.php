<div class="space-y-8">
    <div class="flex justify-between">
        <h2 class="font-heading text-2xl font-bold text-gray-800">Rezervacije</h2>
        <button
            wire:click="$dispatch('openModal', { component: 'admin.reservation-create' })"
            class="font-heading bg-secondary rounded-md px-4 py-3 text-white">
            Kreiraj novu rezervaciju
        </button>
    </div>

    @if (session()->has('message'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
        {{ session('message') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Pretraga: gost, telefon, događaj, stol..."
            class="font-heading w-full rounded-md">

        <select wire:model.live="eventId" class="font-heading w-full rounded-md">
            <option value="">Svi događaji</option>
            @foreach($events as $event)
            <option value="{{ $event->id }}">{{ $event->date->format('d.m.Y') }} – {{ $event->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="status" class="font-heading w-full rounded-md">
            <option value="">Svi statusi</option>
            @foreach(\App\Models\Reservation::STATUS_LABELS as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex justify-between items-center">
        <p>Ukupno: {{ $reservations->total() }}</p>
        <button
            wire:click="downloadPdf"
            class="bg-secondary text-white px-4 py-2 rounded mb-4 hover:bg-primary/80 transition">
            Preuzmi listu (PDF)
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
                <tr>
                    <th class="py-3 px-6 text-left">Gost</th>
                    <th class="py-3 px-6 text-left">Događaj</th>
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
                @forelse($reservations as $reservation)
                @php
                $statusColors = [
                    'active' => 'bg-green-100 text-green-800',
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                ];
                @endphp
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6">
                        {{ $reservation->guestDisplayName() }}
                        @if($reservation->guest_name)
                        <span class="block text-xs text-gray-500">unio admin</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">{{ $reservation->event->name }}</td>
                    <td class="py-3 px-6">{{ $reservation->event->date->format('d/m/Y') }}</td>
                    <td class="py-3 px-6">{{ $reservation->table->name }}</td>
                    <td class="py-3 px-6">{{ $reservation->notes }}</td>
                    <td class="py-3 px-6">{{ $reservation->num_people }}</td>
                    <td class="py-3 px-6">{{ $reservation->contactEmail() }}</td>
                    <td class="py-3 px-6">{{ $reservation->contactPhone() }}</td>
                    <td class="py-3 px-6">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $reservation->statusLabel() }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
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
                @empty
                <tr>
                    <td colspan="10" class="py-6 text-center text-gray-500">Nema rezervacija za zadane filtere.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>
        {{ $reservations->links() }}
    </div>
</div>
