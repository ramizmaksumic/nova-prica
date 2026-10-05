<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4">Uredi stol</h2>

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label class="block font-heading mb-1">Naziv</label>
            <input type="text" wire:model="name" class="w-full rounded">
        </div>
        <div>
            <label class="block font-heading mb-1">Min kapacitet</label>
            <input type="number" wire:model="min_capacity" class="w-full rounded">
        </div>
        <div>
            <label class="block font-heading mb-1">Max kapacitet</label>
            <input type="number" wire:model="max_capacity" class="w-full rounded">
        </div>
        <div>
            <label class="block font-heading mb-1">Opis</label>
            <input type="text" wire:model="description" class="w-full rounded">
        </div>

        @if ($errors->any())
        <ul class="text-red-600 text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif



        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Otkaži</button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Spremi promjene</button>
        </div>
    </form>
</div>