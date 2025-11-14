@livewireStyles

<div class="space-y-8">
    <div class="flex justify-between">
        <h2 class="font-heading text-2xl font-bold text-gray-800">Novosti</h2>
        <button
            wire:click="$dispatch('openModal', { component: 'admin.post-create' })"

            class="font-heading bg-secondary rounded-md px-4 py-3 text-white">
            Kreiraj novi post
        </button>


    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
            <tr>
                <th class="py-3 px-6 text-left">Naziv</th>
                <th class="py-3 px-6 text-left">Datum</th>
                <th class="py-3 px-6 text-center">Akcija</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-6">{{ $post->title }}</td>
                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($post->date)->format('d/m/Y H:i') }}</td>

                <td class="py-3 px-6 text-center">
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.post-update', arguments: { postId: {{ $post->id }} } })"
                        class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button
                        wire:click="$dispatch('openModal', { component: 'admin.post-delete', arguments: { postId: {{ $post->id }} } })"
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