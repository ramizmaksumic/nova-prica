<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4">Edit rezervacije</h2>

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label class="block font-heading mb-1">Događaj</label>
            <select wire:model="event" class="w-full border rounded p-2">
                <option value="">Odaberite događaj</option>
                @foreach($events as $e)
                <option value="{{ $e->id }}">{{ $e->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-heading mb-1">Stol</label>
            <select wire:model="table" class="w-full border rounded p-2">
                <option value="">Odaberite stol</option>
                @foreach($tables as $tbl)
                <option value="{{ $tbl->id }}">{{ $tbl->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-heading mb-1">Broj osoba</label>
            <input type="number" wire:model="num_people" min="1" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-heading mb-1">Napomena</label>
            <textarea wire:model="notes" class="w-full border rounded p-2"></textarea>
        </div>
        <div>
            <label class="block font-heading mb-1">Status</label>
            <select wire:model="status" class="w-full border rounded p-2">
                <option value="" selected>Odaberite status rezervacije</option>
                <option value="active">Aktivna</option>
                <option value="pending">Na čekanju</option>
                <option value="cancelled">Otkazana</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Otkaži</button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Sačuvaj</button>
        </div>
    </form>
</div>