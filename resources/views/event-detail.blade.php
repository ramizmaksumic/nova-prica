@extends('layouts.app')

@section('content')

<!-- TITLE -->

<section class="title text-center h-48 flex flex-col justify-center items-center mb-10">
    <h1 class="font-heading text-6xl font-bold pt-20">{{ $event->name }}</h1>
    <div class="flex justify-center mt-10 text-xl items-center gap-x-4">
        <i class="fa-solid fa-house"></i> &rarr; <h4 class="font-heading">{{ $event->name }}</h4>

    </div>

</section>

<!-- MAIN CONTENT -->
<section class="bg-white flex flex-col px-5 py-10 md:px-20 md:py-20">
    <div class="flex flex-col md:flex-row gap-x-5">
        <!-- LEFT COLUMN -->
        <div class="w-full md:w-1/2">
            <h3 class="font-heading font-bold text-3xl">{{ $event->name }}</h3>
            <div class="flex justify-start gap-x-5">
                <p class="font-heading bg-primary py-2 px-5 text-white mt-5">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                <p class="font-heading bg-primary py-2 px-5 text-white mt-5">{{$event->price}},00 KM</p>
            </div>
            <p class="mt-5">{{$event->description}}</p>
            <p class="font-heading mt-5 mb-10"><span class="font-heading font-bold">Napomena:</span>uz rezervaciju je obavezna boca pića. <br>
                @guest
                Samo registrirani i logirani korisnici mogu izvršiti rezervaciju.
                <span class="text-blue-500"><a href="{{ route('register') }}">Kreiraj profil</a> | <a href="{{ route('login') }}">Prijavi se</a></span>

                @endguest

            </p>


            <img src="{{ asset ('images/events/retro.jpg')}}" alt="" class="w-full h-[650px] object-cover">
        </div>

        <!-- RIGHT COLUMN -->
        <div class="w-full md:w-1/2">
            <!-- Reservation Message -->

            <div class="mt-4">
                @if(session('success'))
                <p class="bg-slate-100 text-green-500 font-medium p-3 rounded">
                    {{ session('success') }}
                </p>
                @endif

                @if($errors->any())
                <p class="bg-red-100 text-red-700 p-3 rounded">
                    {{ $errors->first() }}
                </p>
                @endif
            </div>

            <!-- Table Layout -->
            <div class="">
                <x-table-layout-component :event="$event"></x-table-layout-component>

            </div>

        </div>

    </div>


</section>

@endsection