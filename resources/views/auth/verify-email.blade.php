<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Zahvaljujemo se na registraciji! Prije nego nastavimo dalje potrebno je još samo da potvrdite vaš email. To možete učiniti tako što ćete kliknuti na link koji smo vam poslali na mail. Ako niste dobili link rado ćemo vam poslati novi.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
        {{ __('Novi verifikacijski link vam je poslan na email pomoću kojeg ste se registrirali.') }}
    </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Pošalji ponovo link') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>