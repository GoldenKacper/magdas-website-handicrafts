<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AdminLocaleController extends Controller
{
    protected $allowed = ['pl', 'en'];

    /**
     * Switch locale inside the admin panel (prefix: /admin/{locale}/...)
     */
    public function switch($locale, Request $request)
    {
        if (! in_array($locale, $this->allowed)) {
            abort(404);
        }

        // save locale in session and application
        session(['locale' => $locale]);
        app()->setLocale($locale);

        // Previous URL
        $prev = url()->previous();
        $parsed = parse_url($prev);
        $path = $parsed['path'] ?? '/';

        // Split URL into segments
        // /admin/pl/home → ['admin','pl','home']
        $segments = collect(explode('/', trim($path, '/')));

        /**
         * Expected layout:
         * segment[0] = 'admin'
         * segment[1] = {locale} (pl|en)
         * segment[2...] = rest of the path
         *
         * We need to replace only segment[1]
         */
        if (
            $segments->count() >= 2 &&
            $segments[0] === 'admin' &&
            in_array($segments[1], $this->allowed)
        ) {
            // replace only language
            $segments[1] = $locale;
        } else {
            // fallback — if someone changes language outside admin
            $segments->prepend('admin');
            $segments->prepend($locale);
        }

        // Build the corrected URL
        $newPath = '/' . $segments->implode('/');

        // keep query string if exists
        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';

        return redirect($newPath . $query);
    }

    public function redirectRoot(Request $request)
    {
        $locale = $this->resolveLocale($request);

        // if logged in, go to admin home
        if (Auth::check()) {
            return redirect()->route('admin.home', ['locale' => $locale]);
        }

        // else go to admin login
        // for security purposes it will be commented out
        // if (Route::has('login')) {
        //     return redirect()->route('login', ['locale' => $locale]);
        // }

        // fallback if login route does not exist
        abort(404);
    }

    public function redirectLogin(Request $request)
    {
        if (!Route::has('login')) {
            abort(404);
        }

        $locale = $this->resolveLocale($request);

        return redirect()->route('login', ['locale' => $locale]);
    }
}
