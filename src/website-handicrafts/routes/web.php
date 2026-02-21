<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin routes
Route::prefix('admin')->group(function () {
    Route::prefix('{locale}')->where(['locale' => 'en|pl'])->middleware(['locale'])->group(function () {
        if (method_exists(Auth::class, 'routes')) {
            Auth::routes([
                'register' => config('app.allow_registration', false),
                'verify'   => true,
            ]);
        }

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');

            // Opinion management
            Route::get('/opinion', [App\Http\Controllers\Admin\OpinionController::class, 'index'])->name('admin.opinion.index');
            Route::post('/opinion', [App\Http\Controllers\Admin\OpinionController::class, 'store'])->name('admin.opinion.store');
            Route::post('/opinion/{opinion}', [App\Http\Controllers\Admin\OpinionController::class, 'storeTranslation'])
                ->name('admin.opinion.translation.store');
            Route::get('/opinion/{opinion}/translation/{translation}/edit', [App\Http\Controllers\Admin\OpinionController::class, 'editTranslation'])
                ->name('admin.opinion.translation.edit');
            Route::patch(
                '/opinion/{opinion}/translation/{translation}',
                [App\Http\Controllers\Admin\OpinionController::class, 'updateTranslation']
            )
                ->name('admin.opinion.translation.update');
            Route::delete('/opinion/{opinion}/translation/{translation}', [App\Http\Controllers\Admin\OpinionController::class, 'destroyTranslation'])
                ->name('admin.opinion.translation.destroy'); // Delete translation (and possibly opinion)

            // About management
            Route::get('/about', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('admin.about.index');
            Route::post('/about', [App\Http\Controllers\Admin\AboutController::class, 'store'])->name('admin.about.store');
            Route::post('/about/{about}', [App\Http\Controllers\Admin\AboutController::class, 'storeTranslation'])
                ->name('admin.about.translation.store');
            Route::get('/about/{about}/translation/{translation}/edit', [App\Http\Controllers\Admin\AboutController::class, 'editTranslation'])
                ->name('admin.about.translation.edit');
            Route::patch(
                '/about/{about}/translation/{translation}',
                [App\Http\Controllers\Admin\AboutController::class, 'updateTranslation']
            )
                ->name('admin.about.translation.update');
            Route::delete('/about/{about}/translation/{translation}', [App\Http\Controllers\Admin\AboutController::class, 'destroyTranslation'])
                ->name('admin.about.translation.destroy'); // Delete translation (and possibly about)
        });
    });

    Route::get('/lang/{locale}', [App\Http\Controllers\Admin\AdminLocaleController::class, 'switch'])->name('admin.lang.switch');
    Route::get('/login', [App\Http\Controllers\Admin\AdminLocaleController::class, 'redirectLogin'])->name('admin.login.redirect');
    Route::get('/', [App\Http\Controllers\Admin\AdminLocaleController::class, 'redirectRoot'])->name('admin.home.redirect');
});

// Change language
Route::get('/lang/{locale}', [App\Http\Controllers\LocaleController::class, 'switch'])->name('lang.switch');

// Change locale prefix - website routes
Route::prefix('{locale}')->where(['locale' => 'en|pl'])->middleware(['locale'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
    Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');
    Route::get('/gallery/{slug}', [App\Http\Controllers\GalleryController::class, 'show'])->name('gallery.show');
    Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.send');
});

// Redirect root / -> /{locale}/
Route::get('/', [App\Http\Controllers\LocaleController::class, 'redirectRoot'])->name('home.redirect');

// Default 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
