<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4">Novi događaj</h2>



    <form wire:submit.prevent="save" class="space-y-4" enctype="multipart/form-data">
        <div>
            <label class="block font-heading mb-1">Naziv</label>
            <input type="text" wire:model="name" class="w-full rounded">
            @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Opis</label>
            <textarea wire:model="description" rows="5" class="w-full rounded"></textarea>
            @error('description')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Cijena</label>
            <input type="number" wire:model="price" class="w-full rounded border-1">
            @error('price')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Datum događaja</label>
            <input type="datetime-local" wire:model="date" class="w-full rounded border-1">
            @error('date')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Status</label>
            <select wire:model="status" class="w-full rounded">
                <option value="" selected>Odaberite status</option>
                <option value="active">Aktivan</option>
                <option value="inactive">Neaktivan</option>
            </select>
            @error('status')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block font-heading mb-1">Slika</label>
            {{-- Preview potvrđuje da je upload završen; bez njega bi se događaj tiho spremio bez slike. --}}
            @if ($image && method_exists($image, 'temporaryUrl'))
            <img src="{{ $image->temporaryUrl() }}" class="w-32 rounded mb-2">
            @endif
            <input type="file" wire:model="image" accept="image/*" class="w-full rounded">
            <p wire:loading wire:target="image" class="text-sm text-gray-500 mt-1">Slika se učitava...</p>
            @error('image')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-heading mb-1">Entrio link</label>
            <input type="text" wire:model="link" class="w-full border rounded p-2">
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Otkaži</button>
            <button type="submit" wire:loading.attr="disabled" wire:target="image,save" class="bg-primary text-white px-4 py-2 rounded disabled:opacity-50">Sačuvaj</button>
        </div>
    </form>
</div>