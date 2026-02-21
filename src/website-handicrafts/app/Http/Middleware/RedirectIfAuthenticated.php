<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                // 1. pobieramy locale z trasy, sesji albo configu
                $locale = $request->route('locale')
                    ?? session('locale', app()->getLocale() ?: config('app.locale'));

                // 2. opcjonalne filtrowanie dozwolonych języków
                $allowed = ['pl', 'en']; // albo config('app.allowed_locales')
                if (! in_array($locale, $allowed, true)) {
                    $locale = config('app.locale');
                }

                // 3. przekierowanie dla ZALOGOWANEGO usera
                return redirect()->route('admin.home', ['locale' => $locale]);
            }
        }

        return $next($request);
    }
}
