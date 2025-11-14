<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4">Novi post</h2>



    <form wire:submit.prevent="save" class="space-y-4" enctype="multipart/form-data">
        <div>
            <label class="block font-heading mb-1">Naslov</label>
            <input type="text" wire:model="title" class="w-full rounded">
        </div>
        <div>
            <label class="block font-heading mb-1">Unesite text</label>
            <input type="text" wire:model="body" class="w-full rounded border-1">
        </div>
        <div>
            <label class="block font-heading mb-1">Kratki opis</label>
            <input type="text" wire:model="excerpt" class="w-full rounded border-1">
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