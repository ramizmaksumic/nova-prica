<div class="flex flex-col">

    <!-- TOP MENU -->
    <div class="top-menu flex justify-between bg-secondary text-white py-2 px-20">
        <p class="font-heading">Lacina br. 5, Villa Neretva (Musala)</p>
        <div class="social-links">
            <a href="#" class="font-heading">Facebook</a> |
            <a href="#" class="font-heading">Instagram</a>

        </div>

    </div>

    <!-- MENU -->
    <nav class="bg-white flex flex-col h-[768px] md:h-[100px] md:flex-row px-20 py-2 justify-between items-center shadow-md flex-2">
        <div class="logo">
            <a href="{{ url('/') }}"><img src="{{ asset('images/NovaPrica.png') }}" alt="Nova prica logo" class="w-12"></a>
        </div>
        <div class="menu">
            <ul class="flex flex-col md:flex-row gap-x-12 font-heading text-xl font-medium py-5">
                <li><a href="#" class="hover:bg-black hover:rounded-lg hover:text-white hover:px-2 hover:py-2 duration-150">Home</a></li>
                <li><a href="#" class="hover:bg-black hover:rounded-lg hover:text-white hover:px-2 hover:py-2 duration-150">O nama</a></li>
                <li><a href="{{ route('events') }}" class="hover:bg-black hover:rounded-lg hover:text-white hover:px-2 hover:py-2 duration-150">Događaji</a></li>
                <li><a href="#" class="hover:bg-black hover:rounded-lg hover:text-white hover:px-2 hover:py-2 duration-150">Meni</a></li>
                <li><a href="#" class="hover:bg-black hover:rounded-lg hover:text-white hover:px-2 hover:py-2 duration-150">Novosti</a></li>
                <li><a href="#" class="hover:bg-black hover:rounded-lg hover:text-white hover:px-2 hover:py-2 duration-150">Kontak</a></li>
            </ul>
        </div>
        <div class="login flex gap-x-10">

            @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="flex flex-col">

                    <button><i class="fa-solid fa-right-to-bracket text-xl mr-3"></i>Logout</button>
                    <small>Dobrodošli, <a href="{{ route('profile.index') }}"><span class="font-bold">{{ auth()->user()->name }}</span></a></small>
                </div>
            </form>

            @else
            <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket text-xl"></i></a>
            <a href="{{ route('register') }}"><i class="fa-solid fa-user text-xl"></i></a>

            @endauth

        </div>
    </nav>



</div>