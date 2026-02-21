<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CustomVerifyEmail extends VerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        $locale = app()->getLocale() ?: config('app.locale');

        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'locale' => $locale,
                'id'     => $notifiable->getKey(),
                'hash'   => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
