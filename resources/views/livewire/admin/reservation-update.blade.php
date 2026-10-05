<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4">Edit rezervacije</h2>

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label class="block font-heading mb-1">Događaj</label>
            <select wire:model="event" class="w-full border rounded p-2">
                <option value="">Odaberite događaj</option>
                @foreach($events as $e)
                <option value="{{ $e->id }}">{{ $e->name }} ({{ $e->date->format('d.m.Y') }})</option>
                @endforeach
            </select>
            @error('event') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-heading mb-1">Stol</label>
            <select wire:model="table" class="w-full border rounded p-2">
                <option value="">Odaberite stol</option>
                @foreach($tables as $tbl)
                <option value="{{ $tbl->id }}">{{ $tbl->name }} ({{ $tbl->min_capacity }}–{{ $tbl->max_capacity }} osoba)</option>
                @endforeach
            </select>
            @error('table') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            @error('table_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        @if($isGuestReservation)
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-heading mb-1">Ime i prezime gosta</label>
                <input type="text" wire:model="guest_name" class="w-full border rounded p-2">
                @error('guest_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-heading mb-1">Telefon gosta</label>
                <input type="text" wire:model="guest_phone" class="w-full border rounded p-2">
                @error('guest_phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        @endif

        <div>
            <label class="block font-heading mb-1">Broj osoba</label>
            <input type="number" wire:model="num_people" min="1" class="w-full border rounded p-2">
            @error('num_people') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-heading mb-1">Napomena</label>
            <textarea wire:model="notes" class="w-full border rounded p-2"></textarea>
            @error('notes') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-heading mb-1">Status</label>
            <select wire:model="status" class="w-full border rounded p-2">
                @foreach(\App\Models\Reservation::STATUS_LABELS as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Otkaži</button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded" wire:loading.attr="disabled">Sačuvaj</button>
        </div>
    </form>
</div>
