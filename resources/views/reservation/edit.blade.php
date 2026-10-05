@extends('layouts.app')

@section('title', 'Izmjena rezervacije')
@section('noindex', true)

@section('content')

<section class="flex flex-col px-5 py-10 md:px-20 md:py-20">

    <div class="w-full md:w-1/3">
        <h3 class="font-heading font-bold text-2xl">Zdravo, {{ auth()->user()->name }}</h3>
        <p>Uredite svoju rezervaciju: {{ $reservation->event->name }}, stol {{ $reservation->table->name }} ({{ $reservation->table->min_capacity }}–{{ $reservation->table->max_capacity }} osoba)</p>

        @if($errors->any())
        <p class="bg-red-100 text-red-700 p-3 rounded my-4">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('reservations.update', $reservation->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="event_id" value="{{ $reservation->event_id }}">
            <input type="hidden" name="table_id" value="{{ $reservation->table_id }}">

            <label class="block mb-2 font-heading">Broj osoba</label>
            <input
                type="number"
                name="num_people"
                class="w-full border p-2 rounded mb-4"
                value="{{ old('num_people', $reservation->num_people) }}"
                min="{{ $reservation->table->min_capacity }}"
                max="{{ $reservation->table->max_capacity }}"
                required>

            <label for="notes" class="block mb-2 font-heading">Dodatna napomena</label>
            <input type="text" name="notes" class="w-full rounded-md mb-5" value="{{ old('notes', $reservation->notes) }}" maxlength="255">

            <button type="submit" class="w-full bg-primary text-white py-2 rounded-md">
                Spremi promjene
            </button>
        </form>

    </div>

</section>

@endsection