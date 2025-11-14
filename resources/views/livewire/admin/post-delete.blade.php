<div class="p-6 text-center">
    <h2 class="font-heading text-2xl font-bold mb-4 text-gray-800">Obrisati post?</h2>
    <p class="text-gray-600 mb-6">Ova radnja se ne može poništiti.</p>

    <div class="flex justify-center gap-4">
        <button wire:click="delete"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
            Da, obriši
        </button>
        <button wire:click="$dispatch('closeModal')"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
            Otkaži
        </button>
    </div>
</div>