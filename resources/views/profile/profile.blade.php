@extends('layouts.app')

@section('content')

<section class="flex flex-col px-20 py-20">
    <div>
        <h3 class="text-primary font-heading text-2xl">Dobrodošli, <span class="font-bold">{{ Auth::user()->name }}</span></h3>
        <p class="mt-2">Ovdje možete pregledati i upravljati svojim rezervacijama</p>
    </div>
    <div class="mt-5">
        <div class="overflow-x-auto shadow-sm rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
                    <tr>
                        <th class="py-3 px-6 text-left border-b">Događaj</th>
                        <th class="py-3 px-6 text-left border-b">Datum</th>
                        <th class="py-3 px-6 text-left border-b">Stol</th>
                        <th class="py-3 px-6 text-left border-b">Osoba</th>
                        <th class="py-3 px-6 text-left border-b">Napomene</th>
                        <th class="py-3 px-6 text-left border-b">Status</th>
                        <th class="py-3 px-6 text-center border-b">Akcija</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($reservations as $reservation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-6 font-heading text-gray-800">
                            {{ $reservation->event->name }}
                        </td>

                        <td class="py-3 px-6 text-gray-600">
                            {{ \Carbon\Carbon::parse($reservation->event->date)->format('d/m/Y') }}
                        </td>

                        <td class="font-heading py-3 px-6 text-gray-600 font-medium">
                            {{ $reservation->table->name }}
                        </td>
                        <td class="font-heading py-3 px-6 text-gray-600 font-medium">
                            {{ $reservation->num_people }}
                        </td>
                        <td class="font-heading py-3 px-6 text-gray-600 font-medium">
                            {{ $reservation->notes }}
                        </td>

                        {{-- STATUS --}}
                        <td class="py-3 px-6">
                            @php
                            $status = strtolower($reservation->status);
                            $colors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            @endphp
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>

                        {{-- AKCIJE --}}
                        <td class="py-3 px-6 text-center">
                            <div class="flex justify-center gap-x-4">
                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fa-solid fa-pen-to-square text-xl"></i>
                                </a>

                                <form method="POST" action="{{ route('reservations.destroy', $reservation->id) }}" onsubmit="return confirm('Jeste li sigurni da želite obrisati ovu rezervaciju?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

</section>

@endsection