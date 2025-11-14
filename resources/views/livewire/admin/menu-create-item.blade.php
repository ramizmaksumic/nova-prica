<div class="p-6">

    <h2 class="font-heading text-2xl font-bold mb-4">Novi proizvod</h2>

    <form wire:submit.prevent="save" class="space-y-4">

        <div>
            <label class="font-heading">Naziv</label>
            <input type="text" wire:model="name" class="w-full rounded">
        </div>

        <div>
            <label class="font-heading">Cijena</label>
            <input type="number" step="0.01" wire:model="price" class="w-full rounded">
        </div>

        <div>
            <label class="font-heading">Kategorija</label>
            <select wire:model="menu_category_id" class="w-full rounded">
                <option value="">-- Odaberite --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->type }} - {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-heading">Slika</label>
            <input type="file" wire:model="image">
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded mr-2">
                Otkaži
            </button>

            <button type="submit" class="px-4 py-2 bg-primary text-white rounded">
                Sačuvaj
            </button>
        </div>

    </form>
</div>