<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Priority of locale:
     * 1) route param 'locale' (if using prefix)
     * 2) query ?lang=xx
     * 3) session value 'locale'
     * 4) app default config('app.locale')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowed = ['pl', 'en'];

        // 1) route parameter {locale}
        $locale = $request->route()?->parameter('locale');

        // 2) query param ?lang=pl
        if (! $locale) {
            $locale = $request->get('lang');
        }

        // 3) session fallback
        if (! $locale) {
            $locale = Session::get('locale', config('app.locale'));
        }

        // validate
        if (! in_array($locale, $allowed)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
