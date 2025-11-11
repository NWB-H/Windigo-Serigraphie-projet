<?php

use App\Http\Controllers\InformationController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/boutique', [ShopController::class, 'index'])->name('shop');
Route::get('/produits/{product}', [ShopController::class, 'item'])->name('productItem');

Route::get('/politique-confidentialite', [InformationController::class, 'confidentialite'])->name('confidentialite');
Route::get('/apropos', [InformationController::class, 'about'])->name('about');
Route::get('/portfolio', [InformationController::class, 'portfolio'])->name('portfolio');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
