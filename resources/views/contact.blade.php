@extends('layouts.app')

@section('content')

<section class="title text-center h-48 flex flex-col justify-center items-center mb-10 bg-gray-50">
    <h1 class="font-heading text-6xl font-bold pt-20">Kontakt</h1>
    <div class="flex justify-center mt-4 text-lg items-center gap-x-2 text-gray-700">
        <i class="fa-solid fa-house"></i>
        <span>Početna</span>
        <span class="mx-2">/</span>
        <h4 class="font-semibold text-gray-900">Kontakt</h4>
    </div>
</section>

<section class="flex flex-col px-6 md:px-20 py-20 bg-white">

    <!-- Mapa -->
    <div class="w-full mb-10 shadow-lg rounded-lg overflow-hidden">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2901.5473834164363!2d17.810884899999998!3d43.3446595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x134b43811a0be883%3A0xec80ab5ee97d9a31!2sGastro%20Pub%20Nova%20Pri%C4%8Da!5e0!3m2!1sbs!2sba!4v1762850346245!5m2!1sbs!2sba"
            class="w-full h-64 md:h-80"
            style="border:0;"
            allowfullscreen="yes"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <!-- Kontakt informacije -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
        <div class="flex flex-col items-center p-6 shadow-md rounded-lg hover:shadow-xl transition duration-300">
            <i class="fa-solid fa-house text-3xl text-secondary mb-3"></i>
            <h3 class="font-semibold mb-1">Adresa</h3>
            <p>Lacina br. 5, 88 000 Mostar</p>
        </div>

        <div class="flex flex-col items-center p-6 shadow-md rounded-lg hover:shadow-xl transition duration-300">
            <i class="fa-solid fa-phone-volume text-3xl text-secondary mb-3"></i>
            <h3 class="font-semibold mb-1">Telefon</h3>
            <p>+387 61 111 111</p>
        </div>

        <div class="flex flex-col items-center p-6 shadow-md rounded-lg hover:shadow-xl transition duration-300">
            <i class="fa-solid fa-envelope text-3xl text-secondary mb-3"></i>
            <h3 class="font-semibold mb-1">Email</h3>
            <p>info@nova-prica.ba</p>
        </div>
    </div>

</section>

@endsection