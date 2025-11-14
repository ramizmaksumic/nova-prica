<div class="px-4 md:px-20 py-20">

    {{-- Title --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h2 class="font-heading text-4xl font-bold">Meni ponuda</h2>
            <p class="font-body mt-2 text-gray-600">Izaberite kategoriju i pogledajte ponudu.</p>
        </div>
    </div>

    <div class="mt-10 grid grid-cols-1 md:grid-cols-5 gap-8">

        {{-- LEFT COLUMN: Kategorije (sidebar) --}}
        <div class="md:col-span-1">
            <div class="flex md:flex-col gap-3 overflow-x-auto pb-2 md:pb-0">

                @foreach($categories as $cat)
                <button
                    wire:click="$set('activeCategory', {{ $cat->id }})"
                    class="flex items-center gap-2 px-4 py-2 rounded-md whitespace-nowrap
                        border transition
                        {{ $activeCategory == $cat->id ? 'bg-secondary text-white border-secondary' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">

                    {{-- Ikonica (placeholder dok ne odlučimo koje želiš) --}}
                    <i class="fa-solid fa-tag"></i>

                    {{ $cat->name }}
                </button>
                @endforeach

            </div>
        </div>

        {{-- RIGHT COLUMN: Artikli --}}
        <div class="md:col-span-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach($items as $item)
                <div class="bg-white shadow-sm rounded-lg p-2 text-center hover:shadow-md transition">
                    <img src="{{ asset('storage/' . $item->image) }}"
                        class="w-full h-48 object-cover mb-3" />
                    <h3 class="font-heading text-lg font-bold">{{ $item->name }}</h3>
                    <p class="font-body text-gray-500 mt-1">{{ number_format($item->price, 2) }} KM</p>
                </div>
                @endforeach

            </div>
        </div>

    </div>
</div>