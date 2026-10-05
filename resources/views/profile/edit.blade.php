@extends('layouts.app')

@section('title', 'Uredi profil')
@section('noindex', true)

@section('content')
<section class="flex flex-col px-5 py-10 md:px-20 md:py-20">
    <div class="mb-6">
        <h3 class="text-primary font-heading text-2xl">Uredi profil</h3>
        <a href="{{ route('profile.index') }}" class="text-blue-500">&larr; Nazad na moje rezervacije</a>
    </div>

    <div class="max-w-7xl space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</section>
@endsection
