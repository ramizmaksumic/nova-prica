<div>
    <h2 class="font-heading text-xl mb-4">Piće</h2>

    <table class="w-full table-auto text-left">
        <thead>
            <tr class="border-b">
                <th class="py-2">Slika</th>
                <th>Naziv</th>
                <th>Cijena</th>
                <th>Akcije</th>
            </tr>
        </thead>

        <tbody>
            @foreach($drinkItems as $item)
            <tr class="border-b">
                <td><img src="{{ asset('storage/'.$item->image) }}" class="w-16 h-16 object-cover rounded" /></td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->price }} KM</td>
                <td>
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.menu-update-item', arguments: { ItemId: {{ $item->id }} } })"
                        class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.menu-delete-item', arguments: { itemId: {{ $item->id }} } })"
                        class="text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>