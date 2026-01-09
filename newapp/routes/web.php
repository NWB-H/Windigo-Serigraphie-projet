<?php

use App\Http\Controllers\InformationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/boutique', [ShopController::class, 'index'])->name('shop');
Route::get('/produits/{product}', [ShopController::class, 'item'])->name('productItem');

Route::get('/politique-confidentialite', [InformationController::class, 'confidentialite'])->name('confidentialite');
Route::get('/apropos', [InformationController::class, 'about'])->name('about');
Route::get('/portfolio', [InformationController::class, 'portfolio'])->name('portfolio');
Route::get('/ateliers', [WorkshopController::class, 'workshops'])->name('workshops');
Route::get('/ateliers/{workshop}', [WorkshopController::class, 'workshop'])->name('workshop');
Route::get('/login', [SecurityController::class, 'login'])->name('login');
Route::post('/login', [SecurityController::class, 'loginStore'])->name('login.store');
Route::get('/logout', [SecurityController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/register', [SecurityController::class, 'register'])->name('register');
Route::post('/register', [SecurityController::class, 'registerStore'])->name('register.store');
Route::get('/panier', [ShopController::class, 'cart'])->name('cart');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
