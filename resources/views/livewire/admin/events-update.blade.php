<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4">Uredi događaj</h2>

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label class="block font-heading mb-1">Naziv</label>
            <input type="text" wire:model="name" class="w-full rounded">
            @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Opis</label>
            <input type="text" wire:model="description" class="w-full rounded">
            @error('description')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Cijena</label>
            <input type="number" wire:model="price" class="w-full rounded">
            @error('price')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Datum</label>
            <input type="datetime-local" wire:model="date" class="w-full rounded">
            @error('date')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Slika</label>

            {{-- Preview nove slike --}}
            @if ($newImage)
            <img src="{{ $newImage->temporaryUrl() }}" class="w-32 rounded mb-2">
            {{-- Postojeća slika --}}
            @elseif ($image)
            <img src="{{ asset('storage/' . $image) }}" class="w-32 rounded mb-2">
            @endif

            <input type="file" wire:model="newImage" class="w-full rounded">

            @error('newImage')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-heading mb-1">Status</label>
            <select wire:model="status" class="w-full rounded">
                <option value="active">Aktivan</option>
                <option value="inactive">Neaktivan</option>
            </select>
            @error('status')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Otkaži</button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Spremi promjene</button>
        </div>
    </form>


</div>