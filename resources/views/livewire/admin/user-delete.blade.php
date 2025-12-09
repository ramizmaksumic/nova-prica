<div class="p-6">
    <h2 class="font-heading text-2xl font-bold mb-4 text-red-600">
        Obriši korisnika
    </h2>

    <p class="text-lg mb-6">
        Da li ste sigurni da želite obrisati korisnika:
        <strong>{{ $name }}</strong>?
    </p>

    <div class="flex justify-end gap-x-3">
        <button wire:click="$dispatch('closeModal')"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            Otkaži
        </button>

        <button wire:click="delete"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Obriši
        </button>
    </div>
</div>