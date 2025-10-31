@props(['event'])

@php
use App\Models\Table;
// Učitaj sve stolove i pretvori u array keyBy id -> radi čisto @js
$tables = Table::all()->mapWithKeys(function($t) {
return [$t->id => [
'id' => (int)$t->id,
'name' => $t->name,
'min_capacity' => (int)$t->min_capacity,
'max_capacity' => (int)$t->max_capacity,
'description' => $t->description,
'is_reserved' => (bool)$t->is_reserved,
]];
})->toArray();
@endphp

<div x-data="tableLayout(@js($tables))" class="relative">

    {{-- SVG mapa (ostavi svoj include) --}}
    @include('svg.mapa-stolova')

    @auth
    <!-- Modal -->
    <div
        x-show="showModal"
        x-cloak
        class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
        x-transition>
        <div class="bg-white p-6 rounded-2xl w-96 shadow-lg relative" @click.outside="closeModal()">

            <button class="absolute top-2 right-3 text-gray-500 text-3xl" @click="closeModal()">&times;</button>

            <h3 class="font-heading text-2xl mb-2">
                Rezervacija stola <span x-text="selectedTable ? selectedTable.name : ''"></span>
            </h3>

            <p class="text-gray-600 mb-4" x-show="selectedTable">
                Kapacitet:
                <strong x-text="selectedTable ? selectedTable.min_capacity : ''"></strong>
                &nbsp;–&nbsp;
                <strong x-text="selectedTable ? selectedTable.max_capacity : ''"></strong>
                &nbsp;osoba
            </p>

            <form method="POST" action="{{ route('reservations.store') }}" x-on:submit="if(!selectedTable){ $event.preventDefault(); alert('Molimo izaberite sto.'); }">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                {{-- value se postavlja iz Alpine (dvosmjerno) --}}
                <input type="hidden" name="table_id" :value="selectedTable ? selectedTable.id : ''">

                <label class="block mb-2 font-heading">Broj osoba</label>
                <input
                    type="number"
                    name="num_people"
                    class="w-full border p-2 rounded mb-4"
                    step="1"
                    :min="selectedTable ? selectedTable.min_capacity : 1"
                    :max="selectedTable ? selectedTable.max_capacity : 999"
                    x-bind:disabled="!selectedTable"
                    x-model.number="guestCount"
                    @input="clampGuestCount()"
                    required>

                <label for="notes" class="block mb-2 font-heading">Dodatna napomena</label>
                <input type="text" name="notes" class="w-full rounded-md mb-5">

                <button type="submit" class="w-full bg-primary text-white py-2 rounded-md" :disabled="!selectedTable">
                    Potvrdi rezervaciju
                </button>
            </form>





        </div>
    </div>

    @endauth
</div>

<script>
    function tableLayout(tables) {
        return {
            tables: tables || {}, // objekt: id -> {id,name,min_capacity,...}
            showModal: false,
            selectedTable: null,
            guestCount: 1,

            // pozove se iz SVG: openModal($el.dataset.tableId)
            openModal(id) {
                // id može biti string (iz dataset) - konvertujemo u integer
                const numericId = Number(id);
                // pokušaj dohvatiti po numeric idu ili string key-u
                this.selectedTable = this.tables[numericId] ?? this.tables[id] ?? null;
                if (this.selectedTable) {
                    // inicijalno postavi guestCount na min_capacity (ili 1 ako nema)
                    this.guestCount = this.selectedTable.min_capacity ?? 1;
                    this.showModal = true;
                } else {
                    console.warn('Table with id', id, 'not found in tables object', this.tables);
                }
            },

            closeModal() {
                this.showModal = false;
                this.selectedTable = null;
                this.guestCount = 1;
            },

            clampGuestCount() {
                if (!this.selectedTable) return;
                const min = Number(this.selectedTable.min_capacity) || 1;
                const max = Number(this.selectedTable.max_capacity) || min;
                if (this.guestCount < min) this.guestCount = min;
                if (this.guestCount > max) this.guestCount = max;
            }
        }
    }
</script>