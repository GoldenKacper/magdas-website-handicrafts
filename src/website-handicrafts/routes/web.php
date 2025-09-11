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
    Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
    Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');
    Route::get('/gallery/{id}', [App\Http\Controllers\GalleryController::class, 'show'])->name('gallery.show');
    Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
});

// Redirect root / -> /{locale}/
Route::get('/', [App\Http\Controllers\LocaleController::class, 'redirectRoot'])->name('home.redirect');

// Default 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
