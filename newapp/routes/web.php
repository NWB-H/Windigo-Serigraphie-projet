<?php

use App\Http\Controllers\InformationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/boutique', [ShopController::class, 'index'])->name('shop');
Route::get('/produits/{product}', [ShopController::class, 'item'])->name('productItem');
Route::get('/politique-confidentialite', [InformationController::class, 'confidentialite'])->name('confidentialite');
Route::get('/apropos', [InformationController::class, 'about'])->name('about');
Route::get('/portfolio', [InformationController::class, 'portfolio'])->name('portfolio');
Route::get('/ateliers', [WorkshopController::class, 'workshops'])->name('workshops');
Route::get('/ateliers/{workshop}', [WorkshopController::class, 'workshop'])->name('workshop');
Route::get('/panier', [ShopController::class, 'cart'])->name('cart');

require __DIR__.'/api.php';
require __DIR__.'/auth.php';
