<footer class="bg-secondary text-white py-10 px-6 md:px-16 lg:px-24">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

        <!-- LEFT -->
        <div>
            <h2 class="font-heading text-3xl mb-4">Gastro Pub Nova priča</h2>

            <p class="font-body text-sm leading-relaxed text-white/90">
                Gastro pub Nova priča je već deceniju nezaobilazna stanica mostarskog noćnog života.
                Bili smo domaćini najvećih muzičkih zvijezda regiona. Ako već niste bili, pravo je vrijeme
                da odvojite jedan vikend za nas.
            </p>

            <div class="mt-6 space-y-3 text-sm">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-house w-5"></i>
                    <span>Lacina br. 5, 88 000 Mostar (Trg Musala)</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-phone-volume w-5"></i>
                    <span>+387 62 176 671</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-envelope w-5"></i>
                    <span>info@novaprica.ba</span>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div>
            <p class="font-body text-sm text-white/90">
                Postani dio naše fan baze i prvi saznaj za nove evente i najave.
            </p>

            <form action="{{ route('newsletter.store') }}" method="POST" class="flex mt-4 bg-white/10 rounded-lg overflow-hidden">
                @csrf
                <input type="email" name="email" placeholder="Email adresa..."
                    class="flex-1 px-4 py-2 bg-transparent text-white placeholder-white/60 focus:outline-none">
                <button class="bg-white text-black font-heading px-5 hover:bg-gray-200 transition">
                    Pošalji
                </button>
            </form>

            @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mt-2 rounded mb-4">
                {{ session('message') }}
            </div>
            @endif

            <div class="mt-6 flex items-center gap-4 text-sm font-heading">
                <a href="https://www.facebook.com/novaprica.gastropub" target="_blank" class="hover:text-yellow-300 transition">FACEBOOK</a>
                <span>|</span>
                <a href="https://www.instagram.com/novaprica_gastropub/" target="_blank" class="hover:text-yellow-300 transition">INSTAGRAM</a>
                <span>|</span>
                <a href="#" class="hover:text-yellow-300 transition">YOUTUBE</a>
            </div>
        </div>
    </div>

    <!-- BOTTOM -->
    <div class="border-t border-white/20 mt-10 pt-4 text-xs flex flex-col md:flex-row justify-between items-center gap-2">
        <p>
            &copy; 2025 Gastro pub Nova priča. Sva prava zadržana.
        </p>
        <p>
            Developed by
            <a href="https://reunionagencija.ba" target="_blank" class="hover:text-yellow-300 transition">
                Reunion Web & Marketing
            </a>
        </p>
    </div>

</footer>