<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/** Redirecționări 301/302 administrate din admin (SEO & Conținut → Redirecționări). */
class HandleRedirects
{
    public const CACHE_KEY = 'redirects:map:v1';

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && ! $request->is('admin*', 'portal*', 'livewire*')) {
            $path = '/'.ltrim($request->path(), '/');
            $map = self::map();
            if (isset($map[$path])) {
                [$to, $code] = $map[$path];
                $qs = $request->getQueryString();

                return redirect()->to($to.($qs && ! str_contains($to, '?') ? '?'.$qs : ''), $code);
            }
        }

        return $next($request);
    }

    /** @return array<string,array{0:string,1:int}> */
    public static function map(): array
    {
        try {
            return Cache::remember(self::CACHE_KEY, 3600, fn () => Redirect::query()->get(['from_path', 'to_path', 'status_code'])
                ->mapWithKeys(fn ($r) => ['/'.ltrim($r->from_path, '/') => [$r->to_path, in_array((int) $r->status_code, [301, 302, 307, 308], true) ? (int) $r->status_code : 301]])
                ->all());
        } catch (Throwable) {
            return [];
        }
    }
}
