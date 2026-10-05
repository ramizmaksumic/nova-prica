@extends('layouts.app')

@section('title', $event->name . ' – ' . $event->date->format('d.m.Y.'))
@section('meta_description', $event->date->format('d.m.Y.') . ' u Novoj Priči, Mostar. ' . \Illuminate\Support\Str::limit(strip_tags($event->description), 120) . ' Rezervišite stol online.')
@if($event->image)
@section('og_image', asset('storage/' . $event->image))
@endif
@if(! $event->isActive())
@section('noindex', true)
@endif

@push('structured_data')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Event',
    'name' => $event->name,
    'description' => strip_tags((string) $event->description),
    'startDate' => $event->date->toIso8601String(),
    'endDate' => $event->endsAt()->toIso8601String(),
    'eventStatus' => 'https://schema.org/EventScheduled',
    'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
    'image' => $event->image ? [asset('storage/' . $event->image)] : [asset('images/naslovna.jpg')],
    'location' => [
        '@type' => 'Place',
        'name' => config('app.name'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Lacina br. 5',
            'addressLocality' => 'Mostar',
            'postalCode' => '88000',
            'addressCountry' => 'BA',
        ],
    ],
    'organizer' => ['@type' => 'Organization', 'name' => config('app.name'), 'url' => config('app.url')],
    'offers' => array_filter([
        '@type' => 'Offer',
        'url' => $event->link ?: route('event.detail', $event),
        'price' => $event->price,
        'priceCurrency' => $event->price !== null ? 'BAM' : null,
        'availability' => 'https://schema.org/InStock',
    ], fn ($v) => $v !== null),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
</script>
@endpush

@section('content')

<!-- TITLE -->

<section class="title text-center h-48 flex flex-col justify-center items-center mb-10">
    <h1 class="font-heading text-6xl font-bold pt-20">{{ $event->name }}</h1>
    <div class="flex justify-center mt-10 text-xl items-center gap-x-4">
        <i class="fa-solid fa-house"></i> &rarr; <h4 class="font-heading">{{ $event->name }}</h4>

    </div>

</section>

<!-- MAIN CONTENT -->
<section class="bg-white flex flex-col px-5 py-10 md:px-20 md:py-20">
    <div class="flex flex-col md:flex-row gap-x-5">
        <!-- LEFT COLUMN -->
        <div class="w-full md:w-1/2">
            <h3 class="font-heading font-bold text-3xl">{{ $event->name }}</h3>
            <div class="flex justify-start gap-x-5">
                <p class="font-heading bg-primary py-2 px-5 text-white mt-5">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                <p class="font-heading bg-primary py-2 px-5 text-white mt-5">{{$event->price}},00 KM</p>
            </div>
            <p class="mt-5">{{$event->description}}</p>
            <p class="font-heading mt-5 mb-10"><span class="font-heading font-bold">Napomena:</span>uz rezervaciju je obavezna boca pića. <br>
                @guest
                Samo registrirani i logirani korisnici mogu izvršiti rezervaciju.
                <span class="text-blue-500"><a href="{{ route('register') }}">Kreiraj profil</a> | <a href="{{ route('login') }}">Prijavi se</a></span>

                @endguest

            </p>


            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-[350px] md:h-[650px] object-cover">
        </div>

        <!-- RIGHT COLUMN -->
        <div class="w-full md:w-1/2">
            <!-- Reservation Message -->

            <div class="mt-4">
                @if(session('success'))
                <p class="bg-slate-100 text-green-500 font-medium p-3 rounded">
                    {{ session('success') }}
                </p>
                @endif

                @if($errors->any())
                <p class="bg-red-100 text-red-700 p-3 rounded">
                    {{ $errors->first() }}
                </p>
                @endif
            </div>

            <!-- Table Layout -->
            <div class="w-full">
                <!-- Legend -->
                <div class="flex flex-row justify-start gap-x-5 md:gap-x-20">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-slate-600"></div>
                        <p class="font-heading pl-5 text-xs md:text-lg">Zauzeto</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-[#D9A404]"></div>
                        <p class="font-heading pl-5 text-xs md:text-lg">Na čekanju</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-slate-50 border-2"></div>
                        <p class="font-heading pl-5 text-xs md:text-lg">Slobodno</p>
                    </div>

                </div>

                @if ($eventLink)

                <div class="mt-5">
                    <p class="mb-5">Karte za ovaj događaj su u prodaji putem Entrio platforme. Karte možete kupiti putem sljedećeg linka.</p>
                    <a href="{{ $eventLink }}" target="_blank"
                        class="bg-primary text-white font-heading text-2xl py-3 px-5 rounded-md">
                        Kupi karte &rarr;
                    </a>

                </div>
                @else
                @if($event->hasEnded())
                <p class="mt-5 bg-slate-100 p-3 rounded">Ovaj događaj je završen. Rezervacije više nisu moguće.</p>
                @elseif($userReservation)
                <p class="mt-5 bg-slate-100 p-3 rounded">
                    Već imate rezervaciju za ovaj događaj (stol {{ $userReservation->table->name }}, status: {{ $userReservation->statusLabel() }}).
                    <a href="{{ route('profile.index') }}" class="text-blue-500">Upravljajte rezervacijom na profilu</a>.
                </p>
                @endif

                <!-- Render stolova -->
                <x-table-layout-component
                    :event="$event"
                    :tables="$tables"
                    :reserved-tables="$reservedTables"
                    :pending-tables="$pendingTables"
                    :can-reserve="$event->acceptsReservations() && ! $userReservation"></x-table-layout-component>
                @endif





            </div>

        </div>

    </div>


</section>

@endsection