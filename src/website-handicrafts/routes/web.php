<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->group(function () {
    Auth::routes([
        'register' => config('app.allow_registration', false),
    ]);

    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
});
