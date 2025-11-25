@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="relative h-72 md:h-96 w-full mb-16">
    <img src="{{ asset('storage/' . $post->image) }}"
        alt="{{ $post->title }}"
        class="absolute inset-0 w-full h-full object-cover">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Title -->
    <div class="relative z-10 h-full flex flex-col justify-center items-center text-center text-white px-4">
        <h1 class="font-heading text-4xl md:text-6xl font-bold mb-4">
            {{ $post->title }}
        </h1>

        <div class="flex items-center gap-x-4 text-lg opacity-90">
            <a href="/" class="hover:underline">Početna</a>
            <span>→</span>
            <span>{{ $post->title }}</span>
        </div>
    </div>
</section>


<!-- MAIN CONTENT -->
<section class="px-6 md:px-20 pb-20">

    <div class="grid grid-cols-1 md:grid-cols-12 gap-12">

        <!-- ARTICLE -->
        <article class="md:col-span-8">

            {{-- Featured Image --}}
            <div class="w-full mb-10">
                <img src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="rounded-lg shadow-md w-full max-h-[450px] object-cover">
            </div>
            <!-- Meta info -->
            <div class="mb-6">
                <p class="text-gray-600 font-body">
                    Objavljeno:
                    <span class="font-semibold">
                        {{ $post->created_at->format('d.m.Y') }}
                    </span>
                </p>
            </div>


            <!-- Content -->
            <div class="prose prose-lg max-w-none font-body leading-relaxed">

                {!! nl2br(e($post->body)) !!}

            </div>

            <!-- Share buttons -->
            <div class="mt-12 pt-6 border-t">
                <p class="font-heading mb-3 text-xl">Podijeli članak:</p>

                <div class="flex gap-x-3">
                    <a href="#" class="p-3 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="p-3 bg-sky-500 text-white rounded-full hover:bg-sky-600">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="p-3 bg-red-600 text-white rounded-full hover:bg-red-700">
                        <i class="fa-brands fa-pinterest"></i>
                    </a>
                </div>
            </div>

        </article>


        <!-- SIDEBAR -->
        <aside class="md:col-span-4">

            <h3 class="font-heading text-2xl mb-5">Slične objave</h3>

            @foreach($relatedPosts as $related)
            <a href="{{ route('post.show', $related->id) }}"
                class="flex gap-x-4 mb-6 group">
                <div class="w-24 h-24 bg-gray-200 rounded overflow-hidden">
                    <img src="{{ asset('storage/' . $related->image) }}"
                        class="w-full h-full object-cover group-hover:scale-105 duration-300">
                </div>
                <div>
                    <h4 class="font-heading text-lg group-hover:text-primary duration-200">
                        {{ $related->title }}
                    </h4>
                    <p class="text-gray-500 text-sm">
                        {{ \Illuminate\Support\Str::limit($related->excerpt, 70) }}
                    </p>
                </div>
            </a>
            @endforeach

        </aside>

    </div>

</section>

@endsection