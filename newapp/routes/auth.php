<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Auth\ProductController;
use App\Http\Controllers\Auth\CategoryController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SecurityController::class, 'login'])->name('login');
    Route::post('/login', [SecurityController::class, 'loginStore'])->name('login.store');
    Route::get('/register', [SecurityController::class, 'register'])->name('register');
    Route::post('/register', [SecurityController::class, 'registerStore'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [SecurityController::class, 'logout'])->name('logout');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.index');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.store');
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
});