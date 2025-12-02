<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    protected function redirectTo()
    {
        $request = request();
        $locale = $this->resolveLocale($request);

        return route('admin.home', ['locale' => $locale]);
    }

    /**
     * Show the page with information about the need to verify email.
     * Route: admin/{locale}/email/verify  (verification.notice)
     */
    public function show(Request $request, $locale)
    {
        // If the user has already verified their email, there's no point in showing the info – go to the dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('admin.home', ['locale' => $locale]);
        }

        // Our custom view in the admin folder
        return view('admin.auth.verify');
    }
}
