@livewireStyles

<div class="space-y-8">
    <div class="flex justify-between">
        <h2 class="font-heading text-2xl font-bold text-gray-800">Događaji</h2>
        <button
            wire:click="$dispatch('openModal', { component: 'admin.events-create' })"

            class="font-heading bg-secondary rounded-md px-4 py-3 text-white">
            Kreiraj novi događaj
        </button>


    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
            <tr>
                <th class="py-3 px-6 text-left">Naziv</th>
                <th class="py-3 px-6 text-left">Datum</th>
                <th class="py-3 px-6 text-left">Status</th>
                <th class="py-3 px-6 text-center">Akcija</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-6">{{ $event->name }}</td>
                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</td>
                <td class="py-3 px-6">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </td>
                <td class="py-3 px-6 text-center">
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.events-update', arguments: { eventId: {{ $event->id }} } })"
                        class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.event-delete-confirm', arguments: { eventId: {{ $event->id }} } })"
                        class="text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif
</div>

@livewireScripts