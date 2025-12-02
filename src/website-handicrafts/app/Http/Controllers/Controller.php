<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function resolveLocale(Request $request): string
    {
        $locale = $request->route('locale')
            ?? session('locale', app()->getLocale() ?: config('app.locale'));

        $allowed = ['pl', 'en']; // ew. config('app.allowed_locales')
        if (! in_array($locale, $allowed, true)) {
            $locale = config('app.locale');
        }

        return $locale;
    }
}
