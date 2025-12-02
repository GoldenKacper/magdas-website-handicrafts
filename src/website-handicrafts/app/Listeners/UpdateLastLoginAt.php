<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastLoginAt
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // if you want "remember me",
        // you have this flag:
        // $event->remember === true/false

        $user->forceFill([
            'last_login_at' => now(),
        ])->save();

        $user->increment('login_count');

        \Log::info('Login event fired for user: ' . $event->user->email);
    }
}
