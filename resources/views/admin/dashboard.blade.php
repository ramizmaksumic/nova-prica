<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>


    <title>Admin Panel | Gastro Pub</title>
    @vite('resources/css/app.css')

    @livewireStyles
</head>

<body class="bg-gray-50 font-body text-gray-800">

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-1/4 xl:w-1/5 bg-white shadow-md flex flex-col justify-between">
            <div>
                <div class="p-6 border-b text-center flex flex-col items-center">
                    <img src="{{ asset('images/NovaPrica.png') }}" alt="" class="w-32 ">
                    <h2 class="font-heading text-2xl text-primary font-bold">Admin Panel</h2>
                    <p class="text-sm text-gray-500 mt-1">Upravljanje sistemom</p>
                </div>

                <nav class="mt-6">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('dashboard') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-chart-line w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Pregled</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.events') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('admin.events.*') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-calendar-days w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Događaji</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.reservations') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('admin.reservations.*') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-chair w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Rezervacije</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tables') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('admin.tables.*') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-table w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Stolovi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.posts') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('admin.posts.*') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-newspaper w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Novosti</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.menus') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('admin.menu.*') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-utensils w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Menu</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.contacts') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('admin.contacts.*') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-address-book w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Newsletter kontakti</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users') }}"
                                class="flex items-center px-6 py-3 hover:bg-gray-100 transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 border-l-4 border-primary' : '' }}">
                                <i class="fa-solid fa-person w-6 text-primary"></i>
                                <span class="ml-2 font-heading">Korisnici</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="p-6 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
                        <i class="fa-solid fa-right-from-bracket w-6"></i>
                        <span class="ml-2">Odjavi se</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="font-heading text-3xl font-bold text-gray-800">@yield('title', 'Administracija')</h1>
                    <p class="text-gray-500">Dobrodošli nazad, {{ auth()->user()->name }}</p>
                </div>
                <div class="text-gray-500">
                    <i class="fa-regular fa-clock mr-1"></i>
                    {{ now()->format('d.m.Y H:i') }}
                </div>
            </header>
            <section>
                @yield('content')

            </section>
        </main>

    </div>
    @livewire('livewire-ui-modal')
    @livewireScripts
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>



</body>

</html>