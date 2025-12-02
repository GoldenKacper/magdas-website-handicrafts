<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    protected $allowed = ['pl', 'en'];

    // Change language and redirect to the same route
    public function switch($locale, Request $request)
    {
        if (! in_array($locale, $this->allowed)) {
            abort(404);
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        // Pobranie poprzedniego URL i zmiana pierwszego segmentu (języka)
        $currentUrl = url()->previous();
        $parsed = parse_url($currentUrl);
        $path = $parsed['path'] ?? '/';

        $segments = collect(explode('/', trim($path, '/')));
        if ($segments->count() > 0 && in_array($segments[0], $this->allowed)) {
            $segments[0] = $locale;
        } else {
            $segments->prepend($locale);
        }

        $newPath = '/' . $segments->implode('/');
        return redirect($newPath);
    }

    // Redirect root / -> /{locale}/
    public function redirectRoot(Request $request)
    {
        $locale = $this->resolveLocale($request);
        return redirect("/{$locale}/");
    }
}
