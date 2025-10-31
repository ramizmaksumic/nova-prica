@extends('layouts.app')

@section('content')

<!-- HERO SLIDER -->

<section class="relative h-screen flex flex-col md:flex-row justify-between items-center px-20 py-10 bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/pub.png') }}')">

    <!-- GRADIENT OVERLAY -->
    <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent"></div>

    <!-- CONTENT -->
    <div class="relative z-10 max-w-xl mt-8">
        <h1 class="font-heading text-6xl md:text-8xl lg:text-9xl font-bold tracking-tighter">
            Gastro Pub <br> Nova priča
        </h1>
        <p class="font-body mb-10 mt-10 text-lg">
            Već deceniju mjesto najboljeg provoda u Mostaru. Dom smo nezaboravnih noći i uspomena.
        </p>
        <a href="{{ route('events') }}" class="font-heading text-xl bg-primary text-white py-3 px-6 rounded-md shadow-md hover:bg-primary/90 transition">
            Rezerviraj stol &rarr;
        </a>
    </div>
</section>


<!-- EVENTI -->

<section class="flex flex-col px-20 py-20 bg-white">

    <!-- Gornji red -->

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div class="title">
            <h2 class="font-heading text-5xl font-bold">Novi događaji</h2>
            <p class="font-body mt-5">Nova priča Gastro pub svakog vikenda organizira live događaje.
                Ovdje pogledajte detalje neke od narednih događaja.
            </p>
        </div>
        <div class="text-center mt-10">

            <a href="#" class="font-heading text-xl bg-primary text-white py-3 px-5 mt-5">Vidi sve događaje &rarr;</a>
        </div>


    </div>

    <!-- Event kartice -->

    <div class="flex flex-col md:flex-row justify-between mt-10 gap-x-5">

        @foreach ( $events as $event )
        <div class="card mb-5">
            <img src="{{ $event->image }}" alt="" class="h-[500px]">
            <div class=" flex justify-between items-center font-heading text-lg">
                <h3 class="font-heading text-xl">{{$event->name}}</h3>
                <p class="font-bold">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y.') }}</p>
            </div>
            <a href="{{ route('event.detail', $event->id) }}"
                class="bg-primary text-white font-heading w-full py-3 mt-3 text-xl block text-center">
                Rezerviraj stol &rarr;
            </a>
        </div>

        @endforeach
    </div>


</section>

<!--MENI-->

<section class="  bg-slate-100 flex flex-col px-20 py-20">

    <!-- NASLOV -->
    <div class="flex flex-col md:flex-row justify-between  items-start md:items-center">
        <div class="title">
            <h2 class="font-heading text-5xl font-bold">Meni ponuda</h2>
            <p class="font-body mt-5">Imamo vrhunsku gastro ponudu hrane i pića, sa odličnim cijenama. Ispod pogledajte naše istaknute artikle.
            </p>
        </div>
        <div class="text-center mt-10">

            <a href="#" class="font-heading text-xl bg-primary text-white py-3 px-5 mt-5 hover:drop-shadow-md">Vidi full ponudu &rarr;</a>
        </div>


    </div>

    <!-- ISTAKNUTI ARTIKLI -->
    <div class="flex flex-col md:flex-row mt-10 justify-between gap-x-10 overflow-hidden gap-y-4">

        <div class="w-1/3 flex-row md:flex-col">
            <div class="flex gap-x-5 justify-between">
                <img src="{{ asset('images/burger.jpg') }}" alt="" class="w-64 rounded-md">
                <img src="{{ asset('images/burger.jpg') }}" alt="" class="w-64 rounded-md">
            </div>
            <h3 class="font-heading font-bold text-xl mt-5"><span class="bg-primary py-1 px-3 rounded-md text-white">Istaknuto:</span> Burger u umaku od hrena</h3>
            <p class="mt-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Atque itaque repellat quis odio nobis dicta dolores illo aperiam
                voluptatibus maxime!
            </p>
            <br>
            <h3 class="font-heading font-bold text-xl mt-3"><span class="bg-primary py-1 px-3 rounded-md text-white">Istaknuto:</span> Burger u umaku od hrena</h3>
            <p class="mt-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Atque itaque repellat quis odio nobis dicta dolores illo aperiam
                voluptatibus maxime!
            </p>


        </div>
        <div class="w-2/3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>

                    <img src="{{ asset('images/coctail.jpg') }}" alt="" class="rounded-lg w-96 hover:grayscale">
                </div>
                <div>
                    <img src="{{ asset('images/coctail.jpg') }}" alt="" class="rounded-lg w-96">
                </div>
                <div>
                    <img src="{{ asset('images/coctail.jpg') }}" alt="" class="rounded-lg w-96">
                </div>
                <div>
                    <img src="{{ asset('images/coctail.jpg') }}" alt="" class="rounded-lg w-96">
                </div>
                <div>
                    <img src="{{ asset('images/coctail.jpg') }}" alt="" class="rounded-lg w-96">
                </div>
                <div>
                    <img src="{{ asset('images/coctail.jpg') }}" alt="" class="rounded-lg w-96">
                </div>



            </div>
        </div>



    </div>

</section>

<!-- BANER -->

<section class="bg-white">
    <div class="bg-primary  h-48 text-center font-heading text-3xl font-medium flex items-center justify-center text-white">Mjesto za baner reklamu</div>

</section>

<!-- NEWS -->

<section class="flex flex-col px-20 py-20 bg-white">
    <!-- Gornji red -->

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div class="title">
            <h2 class="font-heading text-5xl font-bold">Fun Facts</h2>
            <p class="font-body mt-5">Fun facts & ostale zanimljivosti iz našeg objekta i svijeta gastronomije na jednom mjestu.
            </p>
        </div>
        <div class="text-center mt-10">

            <a href="#" class="font-heading text-xl bg-primary text-white py-3 px-5 mt-5">Vidi sve zanimljivosti &rarr;</a>
        </div>


    </div>

    <!-- NEWS CARDS -->

    <div class="flex flex-col md:flex-row gap-x-5 justify-between mt-10">
        <div class="news-card">
            <img src="{{ asset('images/pub.jpg') }}" alt="">
            <h3 class="font-heading text-xl mt-3">Jedinstveno u gradu</h3>
            <p class="mt-3 mb-5">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Doloribus asperiores repudiandae vitae temporibus quisquam eligendi
                quis numquam facere eaque possimus?
            </p>
            <a href="" class="bg-black py-2 text-white font-heading px-5">Čitaj više &rarr;</a>

        </div>
        <div class="news-card">
            <img src="{{ asset('images/pub.jpg') }}" alt="">
            <h3 class="font-heading text-xl mt-3">Jedinstveno u gradu</h3>
            <p class="mt-3 mb-5">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Doloribus asperiores repudiandae vitae temporibus quisquam eligendi
                quis numquam facere eaque possimus?
            </p>
            <a href="" class="bg-black py-2 text-white font-heading px-5">Čitaj više &rarr;</a>

        </div>
        <div class="news-card">
            <img src="{{ asset('images/pub.jpg') }}" alt="">
            <h3 class="font-heading text-xl mt-3">Jedinstveno u gradu</h3>
            <p class="mt-3 mb-5">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Doloribus asperiores repudiandae vitae temporibus quisquam eligendi
                quis numquam facere eaque possimus?
            </p>
            <a href="" class="bg-black py-2 text-white font-heading px-5">Čitaj više &rarr;</a>

        </div>
        <div class="news-card">
            <img src="{{ asset('images/pub.jpg') }}" alt="">
            <h3 class="font-heading text-xl mt-3">Jedinstveno u gradu</h3>
            <p class="mt-3 mb-5">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Doloribus asperiores repudiandae vitae temporibus quisquam eligendi
                quis numquam facere eaque possimus?
            </p>
            <a href="" class="bg-black py-2 text-white font-heading px-5">Čitaj više &rarr;</a>

        </div>




    </div>



</section>

@endsection