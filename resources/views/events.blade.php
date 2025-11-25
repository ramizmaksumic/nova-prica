@extends('layouts.app')

@section('content')

<!-- TITLE -->
<section class="title text-center h-48 flex flex-col justify-center items-center mb-10 bg-gray-50">
    <h1 class="font-heading text-6xl font-bold pt-20">Događaji</h1>
    <div class="flex justify-center mt-4 text-lg items-center gap-x-2 text-gray-700">
        <i class="fa-solid fa-house"></i>
        <span>Početna</span>
        <span class="mx-2">/</span>
        <h4 class="font-semibold text-gray-900">Događaji</h4>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="flex flex-col px-6 md:px-20 py-20 bg-white">

    <!-- Gornji red -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
        <div class="title">
            <h2 class="font-heading text-5xl font-bold">Novi događaji</h2>
            <p class="font-body mt-5 text-gray-700">Nova priča Gastro pub svakog vikenda organizira live događaje.
                Ovdje pogledajte detalje neke od narednih događaja.
            </p>
        </div>
    </div>

    <!-- Event kartice -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-10">
        @foreach ($events as $event)
        <div class="relative bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
            <!-- Slika -->
            <img src="{{ 'storage/' . $event->image }}" alt="{{ $event->name }}" class="w-full h-64 object-cover">

            <!-- Badge za datum -->
            <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-semibold">
                {{ \Carbon\Carbon::parse($event->date)->format('d.m.Y.') }}
            </div>

            <!-- Badge za naziv -->
            <h2 class="font-heading text-2xl font-medium pl-4 pt-3">{{ $event->name }}</h2>

            <!-- Kartica sadržaj -->
            <div class="p-4 flex flex-col justify-between h-32">
                <p class="text-gray-600">{{ Str::limit($event->description, 80) }}</p>
                <a href="{{ route('event.detail', $event->id) }}"
                    class="bg-primary text-white font-heading w-full py-2 mt-4 text-center rounded-lg hover:bg-primary-dark transition">
                    Rezerviraj stol &rarr;
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection