<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin routes
Route::prefix('admin')->group(function () {
    Auth::routes([
        'register' => config('app.allow_registration', false),
    ]);

    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
});

// Change language
Route::get('/lang/{locale}', [App\Http\Controllers\LocaleController::class, 'switch'])->name('lang.switch');

// Change locale prefix - website routes
Route::prefix('{locale}')->where(['locale' => 'en|pl'])->middleware(['locale'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// Redirect root / -> /{locale}/
Route::get('/', [App\Http\Controllers\LocaleController::class, 'redirectRoot'])->name('home.redirect');
