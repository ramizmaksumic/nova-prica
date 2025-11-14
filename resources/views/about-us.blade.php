@extends('layouts.app')

@section('content')

<section class="title text-center h-48 flex flex-col justify-center items-center mb-10">
    <h1 class="font-heading text-6xl font-bold pt-20">O nama</h1>
    <div class="flex justify-center mt-10 text-xl items-center gap-x-4">
        <i class="fa-solid fa-house"></i> &rarr; <h4 class="font-heading">O nama</h4>

    </div>
</section>

<section class="px-20 py-20 bg-white">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <!-- IMAGE -->
        <div>
            <img src="{{ asset('images/pub.jpg') }}"
                class="rounded-lg shadow-lg w-120 object-cover">
        </div>

        <!-- TEXT -->
        <div>
            <h2 class="font-heading text-5xl font-bold mb-6">Naša priča</h2>
            <p class="font-body text-lg leading-relaxed">
                Gastro Pub Nova priča već deset godina predstavlja jedinstveno iskustvo
                mostarskog noćnog života. Od vrhunske gastro ponude do nezaboravnih
                muzičkih događaja – naš pub ostavlja trag i privlači posjetitelje iz regiona.
            </p>

            <p class="font-body text-lg leading-relaxed mt-4">
                Kroz godine smo ugostili najveće muzičke zvijezde Balkana i stvorili
                kultno mjesto okupljanja. Uvijek težimo boljem, uvijek nudimo više.
            </p>
        </div>

    </div>
</section>

<!-- TIMELINE SECTION -->
<section class="px-20 py-20 bg-slate-100">
    <div class="text-center mb-12">
        <h2 class="font-heading text-4xl font-bold">Kako izvršiti rezervaciju?</h2>
        <p class="font-body mt-3">Proces rezervacije je jednostavan i traje manje od jedne minute.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

        <!-- Step 1 -->
        <div class="flex flex-col items-center text-center">
            <div class="bg-primary text-white p-6 rounded-full text-3xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h3 class="font-heading text-xl mt-4">1. Odaberite događaj</h3>
            <p class="font-body mt-2">Pregledajte našu listu aktuelnih događaja i izaberite termin koji vam odgovara.</p>
        </div>

        <!-- Step 2 -->
        <div class="flex flex-col items-center text-center">
            <div class="bg-primary text-white p-6 rounded-full text-3xl">
                <i class="fa-solid fa-chair"></i>
            </div>
            <h3 class="font-heading text-xl mt-4">2. Izaberite sto</h3>
            <p class="font-body mt-2">Odaberite lokaciju sjedenja – VIP, šank, lounge ili standardni stol.</p>
        </div>

        <!-- Step 3 -->
        <div class="flex flex-col items-center text-center">
            <div class="bg-primary text-white p-6 rounded-full text-3xl">
                <i class="fa-solid fa-user"></i>
            </div>
            <h3 class="font-heading text-xl mt-4">3. Unesite podatke</h3>
            <p class="font-body mt-2">Unesite svoje kontakt podatke kako bi potvrdili rezervaciju.</p>
        </div>

        <!-- Step 4 -->
        <div class="flex flex-col items-center text-center">
            <div class="bg-primary text-white p-6 rounded-full text-3xl">
                <i class="fa-solid fa-bell-concierge"></i>
            </div>
            <h3 class="font-heading text-xl mt-4">4. Dođite na vrijeme</h3>
            <p class="font-body mt-2">Vaša rezervacija vas čeka. Dolazite – i zabava počinje!</p>
        </div>

    </div>
</section>

<!-- WHY US SECTION -->
<section class="px-20 py-20 bg-white">
    <div class="text-center mb-12">
        <h2 class="font-heading text-4xl font-bold">Zašto izabrati nas?</h2>
        <p class="font-body mt-3">Stvaramo atmosferu koju ljudi pamte i rado se vraćaju.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- Card 1 -->
        <div class="bg-slate-100 p-8 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="font-heading text-2xl mb-4">10+ godina iskustva</h3>
            <p class="font-body">Naša tradicija i iskustvo čine nas jednim od najprepoznatljivijih pubova u Mostaru.</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-slate-100 p-8 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="font-heading text-2xl mb-4">Vrhunska gastro ponuda</h3>
            <p class="font-body">Kombinujemo moderno i tradicionalno kako bismo vam pružili jedinstven doživljaj okusa.</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-slate-100 p-8 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="font-heading text-2xl mb-4">Najbolji događaji u gradu</h3>
            <p class="font-body">Od DJ nastupa do live svirki – donosimo vam samo najbolje.</p>
        </div>

    </div>
</section>

@endsection