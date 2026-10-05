<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            // Npr. istekao/obrisan OAuth klijent, pogrešan redirect URI ili korisnik odbio pristup.
            Log::warning('Google prijava nije uspjela', ['error' => $e->getMessage()]);

            return redirect()->route('login')->withErrors([
                'email' => 'Greška prilikom Google prijave. Pokušajte ponovo ili se prijavite emailom.',
            ]);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->user['given_name'] ?? $googleUser->getName(),
                'surname' => $googleUser->user['family_name'] ?? null,
                'email' => $googleUser->getEmail(),
                'password' => Str::random(32), // Google prijava ne koristi lozinku
            ]);
        }

        // Google je već potvrdio email adresu. Ako je nalog bio neverifikovan, lozinku je mogao
        // postaviti neko drugi (registracija tuđim emailom), pa se ona poništava.
        if (! $user->hasVerifiedEmail()) {
            $user->password = Str::random(32);
            $user->markEmailAsVerified();
        }

        Auth::login($user, remember: true);
        request()->session()->regenerate();

        if ($eventId = session()->pull('last_event')) {
            return redirect()->route('event.detail', $eventId);
        }

        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('events');
    }
}
