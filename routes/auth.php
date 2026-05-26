<?php

use App\Http\Controllers\Auth\CartController;
use App\Http\Controllers\Auth\CategoryController;
use App\Http\Controllers\Auth\OptionController;
use App\Http\Controllers\Auth\ProductController;
use App\Http\Controllers\Auth\WorkshopController;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SecurityController::class, 'login'])->name('login');
    Route::post('/login', [SecurityController::class, 'loginStore'])->name('login.store');
    Route::get('/register', [SecurityController::class, 'register'])->name('register');
    Route::post('/register', [SecurityController::class, 'registerStore'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [SecurityController::class, 'logout'])->name('logout');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::prefix('admin')->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('', [ProductController::class, 'index'])->name('admin.product.index');
            Route::post('', [ProductController::class, 'store'])->name('admin.product.store');
        });

        Route::prefix('categories')->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('admin.categories.index');
            Route::post('', [CategoryController::class, 'store'])->name('admin.categories.store');
        });

        Route::prefix('options')->group(function () {
            Route::get('', [OptionController::class, 'index'])->name('admin.options.index');
            Route::post('', [OptionController::class, 'store'])->name('admin.options.store');
        });

        Route::prefix('workshops')->group(function () {
            Route::get('', [WorkshopController::class, 'index'])->name('admin.workshops.index');
        });
    });
});
