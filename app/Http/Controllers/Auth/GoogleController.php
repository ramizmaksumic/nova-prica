<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

            // Pronađi ili kreiraj korisnika
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(str()->random(16)), // random jer Google login preskače password
                    'email_verified_at' => now(), // Google email je već verificiran
                ]
            );

            Auth::login($user);

            return redirect()->route('home'); // preusmjeri gdje želiš
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google_error' => 'Greška prilikom Google prijave.',
            ]);
        }
    }
}
