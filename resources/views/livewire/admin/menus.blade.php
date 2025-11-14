<div class="p-6">

    <div class="flex justify-between">
        <h2 class="font-heading text-2xl font-bold text-gray-800">Upravljaj menijem</h2>
        <button
            wire:click="$dispatch('openModal', { component: 'admin.menu-create-item' })"

            class="font-heading bg-secondary rounded-md px-4 py-3 text-white">
            Kreiraj novi proizvod
        </button>


    </div>

    {{-- TABOVI --}}
    <div class="flex gap-4 mb-6 border-b pb-2">
        <button wire:click="setTab('Hrana')"
            class="@if($activeTab==='Hrana') border-b-4 border-primary text-primary @else text-gray-500 @endif px-3 py-2 font-heading">
            Hrana
        </button>

        <button wire:click="setTab('Pića')"
            class="@if($activeTab==='Pića') border-b-4 border-primary text-primary @else text-gray-500 @endif px-3 py-2 font-heading">
            Piće
        </button>
    </div>

    {{-- SADRŽAJ TABA --}}
    @if($activeTab === 'Hrana')
    @include('livewire.admin.menu._food')
    @endif

    @if($activeTab === 'Pića')
    @include('livewire.admin.menu._drinks')
    @endif
</div>