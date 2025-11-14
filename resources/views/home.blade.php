@extends('layouts.app')

@section('content')

<!-- HERO SLIDER -->

<section class="h-screen flex flex-col md:flex-row justify-between items-center px-20 py-10 bg-cover bg-center bg-no-repeat">
    <div class="w-full md:w-1/2">
        <div class="relative z-10 max-w-xl">
            <h1 class="font-heading text-7xl md:text-8xl lg:text-9xl font-bold tracking-tighter fade-in">
                Gastro Pub <br> Nova priča
            </h1>
            <p class="font-body mb-10 mt-10 text-lg">
                Već deceniju mjesto najboljeg provoda u Mostaru. Dom smo nezaboravnih noći i uspomena.
                <br> <br> Ovu aplikaciju smo kreirali radi lakšeg rezerviranja stolova u našem objektu.
            </p>
            <div class="flex gap-x-5">
                <a href="{{ route('events') }}" class="font-heading text-sm md:text-xl bg-primary text-white py-3 px-6 shadow-md hover:bg-secondary transition">
                    Rezerviraj stol &rarr;
                </a>
                <a href="{{ route('events') }}" class="font-heading text-sm md:text-xl bg-secondary text-white py-3 px-6 shadow-md hover:bg-primary transition">
                    Kako rezervisati &rarr;
                </a>

            </div>
        </div>

    </div>
    <div class="relative w-full md:w-1/2">
        <img src="{{ asset('images/mapa-stolova.png') }}" alt="Mapa-stolova" class="w-full fade-in-right">
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

            <a href="{{ route('events') }}" class="font-heading text-xl bg-primary text-white py-3 px-5 mt-5">Vidi sve događaje &rarr;</a>
        </div>


    </div>

    <!-- Event kartice -->

    <div class="grid grid-cols-1 md:grid-cols-4 justify-between mt-10 gap-x-5">

        @foreach ( $events as $event )


        <div class="card mb-5">
            <img src="{{'storage/' . $event->image }}" alt="{{ $event->name }}" class="h-[500px]">
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

<section class="bg-slate-100 px-6 md:px-16 lg:px-24 py-20">

    <!-- NASLOV -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center fade-in">
        <div>
            <h2 class="font-heading text-4xl md:text-5xl font-bold">Meni ponuda</h2>
            <p class="font-body mt-4 text-gray-700 max-w-xl">
                Vrhunsku gastronomska ponuda hrane i pića, pažljivo odabrana i prilagođena svakom gostu.
                Izdvajamo najtraženije iz naše ponude:
            </p>
        </div>

        <a href="#" class="font-heading text-lg bg-primary text-white px-6 py-3 mt-8 md:mt-0 hover:drop-shadow-md transition">
            Vidi full ponudu &rarr;
        </a>
    </div>

    <!-- GRID -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-12">

        <!-- ISTAKNUTA HRANA -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 gap-6">
            @foreach ([
            ['img' => 'burger.jpg', 'name' => 'Burger u umaku od hrena', 'desc' => 'Sočno, aromatično, nezaboravno.'],
            ['img' => 'burger.jpg', 'name' => 'Goveđi burger sa cheddar sirom', 'desc' => 'Naš najtraženiji klasik.'],
            ['img' => 'burger.jpg', 'name' => 'Piletina BBQ', 'desc' => 'Dimljeni BBQ preljev i svježe povrće.'],
            ['img' => 'burger.jpg', 'name' => 'Nova priča Club sandvič', 'desc' => 'Savršeno za lagani večernji zalogaj.'],
            ] as $food)

            <div class="bg-white rounded-xl shadow-sm hover:shadow-md p-3 transition text-center">
                <img src="{{ asset('images/' . $food['img']) }}" class="rounded-lg w-full h-32 object-cover mb-3">
                <h3 class="font-heading text-lg font-bold">{{ $food['name'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $food['desc'] }}</p>
            </div>

            @endforeach
        </div>

        <!-- PIĆA -->
        <div class="md:col-span-2">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach ([
                ['img' => 'Jägermeister.png', 'price' => '90'],
                ['img' => 'johnie.png', 'price' => '90'],
                ['img' => 'jack daniels.png', 'price' => '100'],
                ['img' => 'Vodka.png', 'price' => '95'],
                ['img' => 'Vranac.png', 'price' => '85'],
                ['img' => 'Krstač.png', 'price' => '70'],
                ['img' => 'heineken.png', 'price' => '4'],
                ['img' => 'Corona.png', 'price' => '4'],
                ] as $item)

                <div class="relative p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition">

                    <span class="absolute top-2 right-2 bg-secondary text-white font-heading text-xs px-3 py-1 rounded-md">
                        Akcija
                    </span>

                    <span class="absolute top-14 right-2 bg-red-600 text-white font-heading text-xs px-3 py-1 rounded-md">
                        {{ $item['price'] }} <sup>00</sup> KM
                    </span>

                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('images/meni/' . $item['img']) }}"
                            class="w-full h-full object-contain">
                    </div>

                </div>
                @endforeach

            </div>
            <div class="flex justify-center md:justify-end gap-x-4 mt-6"> <button class="bg-red-500 text-white px-4 py-2 rounded">&larr;</button> <button class="bg-red-500 text-white px-4 py-2 rounded">&rarr;</button> </div>
        </div>
    </div>

</section>


<!-- BANER -->

<section class="bg-white">
    <div class="bg-primary  h-48 text-center font-heading text-3xl font-medium flex items-center justify-center text-white">Mjesto za baner reklamu</div>

</section>

<!-- NEWS -->

<section class="px-6 md:px-16 lg:px-24 py-20 bg-white">

    <!-- NASLOV -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h2 class="font-heading text-4xl md:text-5xl font-bold">Fun Facts</h2>
            <p class="font-body mt-4 text-gray-700 max-w-xl">
                Fun facts & ostale zanimljivosti iz našeg objekta i svijeta gastronomije.
            </p>
        </div>

        <a href="#" class="font-heading text-lg bg-primary text-white px-6 py-3 mt-8 md:mt-0 hover:drop-shadow-md transition">
            Vidi sve zanimljivosti &rarr;
        </a>
    </div>

    <!-- NEWS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">

        @foreach ($posts as $post)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">

            <img src="{{ asset('storage/' . $post->image) }}"
                class="w-full h-48 object-cover">

            <div class="p-5 flex flex-col h-full">
                <h3 class="font-heading text-xl font-bold text-gray-800">
                    {{ $post->title }}
                </h3>

                <p class="text-gray-600 text-sm mt-3 mb-5">
                    {{ $post->excerpt }}
                </p>

                <a href="{{ route('post.show', $post->id) }}"
                    class="mt-5 inline-block bg-black text-white font-heading px-4 py-2 rounded hover:bg-primary transition">
                    Čitaj više →
                </a>
            </div>

        </div>
        @endforeach

    </div>

</section>


@endsection