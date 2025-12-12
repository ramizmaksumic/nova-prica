<div class="space-y-8">
    <div class="flex justify-between">
        <h2 class="font-heading text-2xl font-bold text-gray-800">Korisnici</h2>
        <button
            wire:click="$dispatch('openModal', { component: 'admin.reservation-create' })"

            class="font-heading bg-secondary rounded-md px-4 py-3 text-white">
            Kreiraj novog korisnika
        </button>

    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
            <tr>
                <th class="py-3 px-6 text-left">Ime</th>
                <th class="py-3 px-6 text-left">Prezime</th>
                <th class="py-3 px-6 text-left">Verifikovan</th>
                <th class="py-3 px-6 text-left">Ovlaštenje</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Telefon</th>
                <th class="py-3 px-6 text-left">Slika</th>
                <th class="py-3 px-6 text-left">Akcija</th>

            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-6">{{ $user->name }}</td>
                <td class="py-3 px-6">{{ $user->surname }}</td>
                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y') }}</td>
                <td class="py-3 px-6">{{ $user->role }}</td>
                <td class="py-3 px-6">{{$user->email }}</td>
                <td class="py-3 px-6">{{$user->phone }}</td>
                <td class="py-3 px-6"><img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->image }}" class="w-24 rounded-md object-cover"></td>

                <td class="py-3 px-6 text-center">
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.user-update', arguments: { userId: {{ $user->id }} } })"
                        class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.user-delete', arguments: { userId: {{ $user->id }} } })"
                        class="text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $users->links() }}
    </div>
</div>