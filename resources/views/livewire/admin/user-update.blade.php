<div class="p-6 space-y-4">
    <h2 class="text-2xl font-heading font-bold mb-4">Uredi korisnika</h2>

    <form wire:submit.prevent="update" class="space-y-4">

        <div>
            <label class="font-heading">Ime i prezime</label>
            <input type="text" wire:model="name" class="w-full rounded">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-heading">Email</label>
            <input type="email" wire:model="email" class="w-full rounded">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-heading">Telefon</label>
            <input type="text" wire:model="phone" class="w-full rounded">
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-heading">Slika</label>
            <input type="file" wire:model="image" class="w-full rounded">
            @if($existingImage)
            <p class="text-sm mt-1">Trenutna: <img src="{{ asset('storage/' . $existingImage) }}" class="h-12 inline-block rounded"></p>
            @endif
            @error('image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-heading">Nova lozinka (opcionalno)</label>
            <input type="password" wire:model="password" class="w-full rounded" placeholder="Ostavi prazno za bez promjene">
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="$dispatch('closeModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">
                Otkaži
            </button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">
                Sačuvaj
            </button>
        </div>

    </form>
</div>