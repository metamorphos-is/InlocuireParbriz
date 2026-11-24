<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * X-Robots-Tag noindex pe toate răspunsurile cât timp e activ comutatorul din Setări site → SEO
 * (pre-lansare). Admin și portalul de parteneri nu se indexează niciodată.
 */
class ForceNoIndex
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Seo::noindex() || $request->is('admin', 'admin/*', 'portal', 'portal/*', 'cerere-oferta/multumim*')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        return $response;
    }
}
