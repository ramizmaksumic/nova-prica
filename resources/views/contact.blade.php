@extends('layouts.app')

@section('content')

<section class="title text-center h-48 flex flex-col justify-center items-center mb-10">
    <h1 class="font-heading text-6xl font-bold pt-20">Kontakt</h1>
    <div class="flex justify-center mt-10 text-xl items-center gap-x-4">
        <i class="fa-solid fa-house"></i> &rarr; <h4 class="font-heading">Contact</h4>

    </div>
</section>

<section class="flex flex-col px-20  py-20 bg-white">
    <div class="flex flex-col">
        <div class="w-full flex justify-center">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2901.5473834164363!2d17.810884899999998!3d43.3446595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x134b43811a0be883%3A0xec80ab5ee97d9a31!2sGastro%20Pub%20Nova%20Pri%C4%8Da!5e0!3m2!1sbs!2sba!4v1762850346245!5m2!1sbs!2sba" width="1600" height="250" style="border:0;" allowfullscreen="yes" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-start md:justify-between px-20 mt-10 font-heading">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-house w-5"></i>
                <span>Lacina br. 5, 88 000 Mostar</span>
            </div>
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-phone-volume w-5"></i>
                <span>+387 61 111 111</span>
            </div>
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-envelope w-5"></i>
                <span>info@nova-prica.ba</span>
            </div>


        </div>


    </div>

</section>

@endsection