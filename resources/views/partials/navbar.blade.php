<div class="flex flex-col">

    <!-- TOP MENU -->
    <div class="top-menu flex justify-between bg-secondary text-white py-2 px-5 md:px-20">
        <p class="font-heading text-sm md:text-base">Lacina br. 5, Villa Neretva (Musala)</p>
        <div class="social-links flex gap-x-3 font-heading text-sm md:text-base opacity-90">
            <a href="https://www.facebook.com/novaprica.gastropub" target="_blank" class="hover:text-yellow-300 transition">FACEBOOK</a>
            <span>|</span>
            <a href="https://www.instagram.com/novaprica_gastropub/" target="_blank" class="hover:text-yellow-300 transition">INSTAGRAM</a>
        </div>
    </div>

    <!-- MAIN NAV -->
    <nav class="bg-white flex flex-row px-5 md:px-20 py-5 justify-between items-center shadow-md">

        <!-- Logo -->
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/NovaPrica.png') }}" alt="Nova prica logo" class="w-14">
        </a>

        <!-- Links -->
        <div class="menu hidden md:block">


            <ul class="flex flex-col md:flex-row gap-y-3 md:gap-x-10 font-heading text-lg mt-4 md:mt-0">
                @php
                $links = [
                ['Home', '/'],
                ['O nama', route('about-us')],
                ['Događaji', route('events')],
                ['Meni', route('menu')],
                ['Kontakt', route('contact')],
                ];
                @endphp

                @foreach ($links as [$label, $url])
                <li>
                    <a href="{{ $url }}"
                        class="inline-block px-3 py-2 rounded-md transition duration-200
                              hover:bg-black hover:text-white">
                        {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Auth -->
        <div class="flex items-center gap-x-4 mt-4 md:mt-0">

            @auth
            <div class="flex items-center gap-x-3 text-sm md:text-base">
                <span class="font-heading">Pozdrav, <a href="{{ route('profile.index') }}"><strong>{{ auth()->user()->name }}</strong></a></span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="px-3 py-1 rounded-md border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition">
                        Logout
                    </button>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}"
                class="p-2 rounded-full border border-gray-300 hover:bg-gray-100 transition">
                <i class="fa-solid fa-right-to-bracket text-lg"></i>
            </a>

            <a href="{{ route('register') }}"
                class="p-2 rounded-full border border-gray-300 hover:bg-gray-100 transition">
                <i class="fa-solid fa-user text-lg"></i>
            </a>
            @endauth

            <button x-data @click="$dispatch('toggle-mobile-menu')"
                class="md:hidden text-3xl text-gray-700">
                <i class="fa-solid fa-bars"></i>
            </button>


        </div>

    </nav>

    <!-- Drawer meni -->

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div
        x-data="{ open: false }"
        x-on:toggle-mobile-menu.window="open = !open">

        <!-- BACKDROP -->
        <div
            x-cloak
            x-show="open"
            x-transition.opacity
            @click="open = false"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40">
        </div>

        <!-- MENU DRAWER -->
        <div
            x-cloak
            x-show="open"
            x-transition.duration.300ms
            class="fixed right-0 top-0 h-full w-3/4 max-w-[280px] bg-white shadow-xl z-50 p-6 flex flex-col gap-y-6">

            <div class="flex justify-between items-center">
                <h3 class="font-heading text-2xl">Meni</h3>
                <button @click="open = false" class="text-2xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <ul class="flex flex-col gap-y-4 text-lg font-heading">
                <li><a href="/" class="hover:text-primary">Home</a></li>
                <li><a href="{{ route('about-us') }}" class="hover:text-primary">O nama</a></li>
                <li><a href="{{ route('events') }}" class="hover:text-primary">Događaji</a></li>
                <li><a href="{{ route('menu') }}" class="hover:text-primary">Meni</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-primary">Kontakt</a></li>
            </ul>

            <div class="mt-auto pt-6 border-t">
                @auth
                <a href="{{ route('profile.index') }}" class="font-heading block mb-3">
                    Profil ({{ auth()->user()->name }})
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="font-heading bg-black text-white w-full py-2 rounded">
                        Logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="font-heading block bg-black text-white w-full text-center py-2 rounded mb-2">
                    Login
                </a>
                <a href="{{ route('register') }}" class="font-heading block bg-gray-200 text-center py-2 rounded">
                    Register
                </a>
                @endauth
            </div>

        </div>

    </div>


</div>