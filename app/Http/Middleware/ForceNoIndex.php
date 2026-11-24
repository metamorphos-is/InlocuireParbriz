<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pre-lansare: toate răspunsurile publice primesc X-Robots-Tag noindex.
 * Se elimină (sau se condiționează prin config) doar la aprobarea lansării.
 */
class ForceNoIndex
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
