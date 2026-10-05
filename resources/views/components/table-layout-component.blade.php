@props(['event', 'tables', 'reservedTables' => [], 'pendingTables' => [], 'canReserve' => false])

@php
// keyBy id -> radi čisto @js
$tablesById = $tables->mapWithKeys(fn ($t) => [$t->id => [
    'id' => (int) $t->id,
    'name' => $t->name,
    'min_capacity' => (int) $t->min_capacity,
    'max_capacity' => (int) $t->max_capacity,
    'description' => $t->description,
]])->toArray();
@endphp

<div x-data="tableLayout(@js($tablesById), @js($canReserve))" class="relative">

    @include('svg.mapa-stolova', ['reservedTables' => $reservedTables, 'pendingTables' => $pendingTables])

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

            <form method="POST" action="{{ route('reservations.store') }}" x-on:submit="if (!selectedTable || submitting) { $event.preventDefault(); return; } submitting = true;">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                {{-- value se postavlja iz Alpine (dvosmjerno) --}}
                <input type="hidden" name="table_id" :value="selectedTable ? selectedTable.id : ''">

                <label class="block mb-2 font-heading">Broj osoba</label>

                <div class="flex items-center gap-3 mb-4">

                    <!-- MINUS -->
                    <button
                        type="button"
                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-xl font-bold hover:bg-gray-300"
                        @click="if (selectedTable && guestCount > selectedTable.min_capacity) { guestCount--; }"
                        :disabled="!selectedTable">−</button>

                    <!-- PRIKAZ BROJA (read-only input) -->
                    <input
                        type="number"
                        name="num_people"
                        class="w-20 text-center border p-2 rounded"
                        x-model.number="guestCount"
                        readonly>

                    <!-- PLUS -->
                    <button
                        type="button"
                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-xl font-bold hover:bg-gray-300"
                        @click="if (selectedTable && guestCount < selectedTable.max_capacity) { guestCount++; }"
                        :disabled="!selectedTable">+</button>
                </div>

                <label for="notes" class="block mb-2 font-heading">Dodatna napomena</label>
                <input type="text" id="notes" name="notes" maxlength="255" class="w-full rounded-md mb-5">

                <button type="submit" class="w-full bg-primary text-white py-2 rounded-md disabled:opacity-60" :disabled="!selectedTable || submitting">
                    <span x-show="!submitting">Potvrdi rezervaciju</span>
                    <span x-show="submitting">Šaljem...</span>
                </button>
            </form>

        </div>
    </div>
    @endauth
</div>

<script>
    function tableLayout(tables, canReserve) {
        return {
            tables: tables || {}, // objekt: id -> {id,name,min_capacity,...}
            canReserve: canReserve,
            showModal: false,
            selectedTable: null,
            guestCount: 1,
            submitting: false,

            // pozove se iz SVG: openModal($el.dataset.tableId)
            openModal(id) {
                if (!this.canReserve) return;

                this.selectedTable = this.tables[Number(id)] ?? null;
                if (this.selectedTable) {
                    this.guestCount = this.selectedTable.min_capacity ?? 1;
                    this.showModal = true;
                } else {
                    console.warn('Table with id', id, 'not found');
                }
            },

            closeModal() {
                this.showModal = false;
                this.selectedTable = null;
                this.guestCount = 1;
            },
        }
    }
</script>
