@extends('layouts.app')

@section('content')

<!-- TITLE -->

<section class="title text-center h-48 flex flex-col justify-center items-center mb-10">
    <h1 class="font-heading text-6xl font-bold pt-20">Događaji</h1>
    <div class="flex justify-center mt-10 text-xl items-center gap-x-4">
        <i class="fa-solid fa-house"></i> &rarr; <h4 class="font-heading">Događaji</h4>

    </div>

</section>

<!-- MAIN CONTENT -->
<section class="flex flex-col px-20 py-20 bg-white">

    <!-- Gornji red -->

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div class="title">
            <h2 class="font-heading text-5xl font-bold">Novi događaji</h2>
            <p class="font-body mt-5">Nova priča Gastro pub svakog vikenda organizira live događaje.
                Ovdje pogledajte detalje neke od narednih događaja.
            </p>
        </div>



    </div>

    <!-- Event kartice -->

    <div class="grid grid-cols-1 md:grid-cols-4 justify-between mt-10 gap-x-5">

        @foreach ($events as $event )
        <div class="card mb-5">
            <img src="{{'storage/' . $event->image}}" alt="" class="h-[500px]">
            <div class=" flex justify-between items-center font-heading text-lg">
                <h3 class="font-heading text-xl">{{$event->name}}</h3>
                <p class="font-bold">{{ \Carbon\Carbon::parse($event->date)->format('d.m.Y.') }}</p>
            </div>
            <a href="{{ route('event.detail', $event->id) }}"
                class="bg-black text-white font-heading w-full py-3 mt-3 text-xl block text-center">
                Rezerviraj stol &rarr;
            </a>
        </div>

        @endforeach





    </div>


</section>

@endsection