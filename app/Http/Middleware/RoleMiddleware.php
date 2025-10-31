<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Provjera da li je korisnik prijavljen
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Provjera da li ima traženu rolu
        if (auth()->user()->role !== $role) {
            abort(403, 'Nemate dozvolu za pristup ovoj stranici.');
        }

        return $next($request);
    }
}
