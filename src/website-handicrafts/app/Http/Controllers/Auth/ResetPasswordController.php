<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Dynamiczny redirect po zresetowaniu hasła.
     */
    protected function redirectTo()
    {
        $request = request();
        $locale = $this->resolveLocale($request);

        // zwracamy path lub URL – oba działają
        return route('admin.home', ['locale' => $locale]);
        // albo: return "/admin/{$locale}/home";
    }

    protected function showResetForm(Request $request, $locale = 'pl', $token = null)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
