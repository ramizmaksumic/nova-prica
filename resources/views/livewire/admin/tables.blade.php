<div class="space-y-8">
    <div class="flex justify-between">

        <h2 class="font-heading text-2xl font-bold text-gray-800">Događaji</h2>
        <button
            wire:click="$dispatch('openModal', { component: 'admin.table-create' })"

            class="font-heading bg-secondary rounded-md px-4 py-3 text-white">
            Kreiraj novi stol
        </button>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
            <tr>
                <th class="py-3 px-6 text-left">Naziv</th>
                <th class="py-3 px-6 text-left">Min. Kapacitet</th>
                <th class="py-3 px-6 text-left">Max. Kapacitet</th>
                <th class="py-3 px-6 text-left">Opis</th>
                <th class="py-3 px-6 text-left">Rezervisan</th>
                <th class="py-3 px-6 text-center">Akcija</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tables as $table)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-6">{{ $table->name }}</td>

                <td class="py-3 px-6">{{$table->min_capacity }}</td>
                <td class="py-3 px-6">{{$table->max_capacity }}</td>
                <td class="py-3 px-6">{{$table->description }}</td>
                <td class="py-3 px-6">{{$table->is_reserved }}</td>
                <td class="py-3 px-6 text-center">
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.table-update', arguments: { tableId: {{ $table->id }} } })"
                        class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button
                        wire:click="$dispatch('openModal', {component: 'admin.table-delete', arguments: {tableId: {{ $table->id }} } })"
                        class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
            @endforeach



        </tbody>
    </table>

    <div>
        {{ $tables->links() }}
    </div>


</div>