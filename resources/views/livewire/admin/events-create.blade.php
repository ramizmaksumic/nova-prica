<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4">Novi događaj</h2>



    <form wire:submit.prevent="save" class="space-y-4" enctype="multipart/form-data">
        <div>
            <label class="block font-heading mb-1">Naziv</label>
            <input type="text" wire:model="name" class="w-full rounded">
        </div>
        <div>
            <label class="block font-heading mb-1">Opis</label>
            <input type="text" wire:model="description" class="w-full rounded">
        </div>
        <div>
            <label class="block font-heading mb-1">Cijena</label>
            <input type="number" wire:model="price" class="w-full rounded border-1">
        </div>
        <div>
            <label class="block font-heading mb-1">Datum događaja</label>
            <input type="date" wire:model="date" class="w-full rounded border-1">
        </div>
        <div>
            <label class="block font-heading mb-1">Status</label>
            <select wire:model="status" class="w-full rounded">
                <option value="" selected>Odaberite status</option>
                <option value="active">Aktivan</option>
                <option value="inactive">Neaktivan</option>
            </select>
        </div>
        <div>
            <label class="block font-heading mb-1">Slika</label>
            <input type="file" wire:model="image" class="w-full rounded">
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Otkaži</button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Sačuvaj</button>
        </div>
    </form>
</div>