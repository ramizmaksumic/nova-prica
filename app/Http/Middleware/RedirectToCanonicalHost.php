<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sajt je dostupan i na www.novaprica.ba i na novaprica.ba, što Google vidi kao dupli sadržaj.
 * U produkciji se svi zahtjevi trajno (301) preusmjeravaju na host iz APP_URL.
 */
class RedirectToCanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $canonicalHost = parse_url(config('app.url'), PHP_URL_HOST);

        if (app()->isProduction()
            && $canonicalHost
            && in_array($request->method(), ['GET', 'HEAD'], true)
            && strcasecmp($request->getHost(), $canonicalHost) !== 0
            && strcasecmp($request->getHost(), 'www.' . $canonicalHost) === 0) {
            return redirect()->to(
                rtrim(config('app.url'), '/') . $request->getRequestUri(),
                301
            );
        }

        return $next($request);
    }
}
