@extends('layouts.app')

@section('content')

<!-- TITLE -->

<section class="title text-center h-48 flex flex-col justify-center items-center mb-10">
    <h1 class="font-heading text-6xl font-bold pt-20">Detaljnije</h1>
    <div class="flex justify-center mt-10 text-xl items-center gap-x-4">
        <i class="fa-solid fa-house"></i> &rarr; <h4 class="font-heading">Događaji</h4>

    </div>

</section>

<!-- MAIN CONTENT -->
<section class="bg-white flex flex-col px-20 py-20">
    <div class="flex flex-col md:flex-row gap-x-5">
        <!-- LEFT COLUMN -->
        <div class="w-1/2">
            <img src="{{ asset('images/Event.jpg') }}" alt="" class="">
        </div>

        <!-- RIGHT COLUMN -->
        <div class="w-1/2">
            <h3 class="font-heading font-bold text-3xl">Boemska večer</h3>
            <div class="flex justify-start gap-x-5">
                <p class="font-heading bg-primary py-2 px-5 text-white mt-5">Petak | 10.10.2025.</p>
                <p class="font-heading bg-primary py-2 px-5 text-white mt-5">Ulaz: 10 KM</p>
            </div>
            <p class="mt-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut sed minima
                adipisci a ipsam dignissimos, esse optio officia laborum inventore!</p>
            <!-- Table Layout -->
            <div>
                <x-table-layout-component></x-table-layout-component>
                <p class="font-heading mb-5"><span class="font-heading font-bold">Napomena:</span>uz rezervaciju je obavezna boca pića.
                    Samo registrirani i logirani korisnici mogu izvršiti rezervaciju. </p>
                <a href="{{ route('reservations.create') }}" class="font-heading text-xl bg-primary text-white p-4 rounded-md">Rezerviraj stol</a>

            </div>

        </div>

    </div>

</section>

@endsection