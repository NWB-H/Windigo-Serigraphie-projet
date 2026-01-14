<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Auth\AdminController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SecurityController::class, 'login'])->name('login');
    Route::post('/login', [SecurityController::class, 'loginStore'])->name('login.store');
    Route::get('/register', [SecurityController::class, 'register'])->name('register');
    Route::post('/register', [SecurityController::class, 'registerStore'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [SecurityController::class, 'logout'])->name('logout');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});