<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    /**
     * Zbudowanie URL do resetu hasła z uwzględnieniem locale.
     */
    protected function resetUrl($notifiable)
    {
        // locale ustawione przez Twój middleware SetLocale
        $locale = app()->getLocale() ?: config('app.locale');

        return url(route('password.reset', [
            'locale' => $locale,
            'token'  => $this->token,
            'email'  => $notifiable->getEmailForPasswordReset(),
        ], false)); // false = nie doklejaj base URL drugi raz
    }
}
