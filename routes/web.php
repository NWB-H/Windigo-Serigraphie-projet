<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/boutique', [ShopController::class, 'index'])->name('shop');
Route::get('/produits/{product}', [ShopController::class, 'item'])->name('productItem');
Route::get('/politique-confidentialite', [InformationController::class, 'confidentialite'])->name('confidentialite');
Route::get('/apropos', [InformationController::class, 'about'])->name('about');
Route::get('/portfolio', [InformationController::class, 'portfolio'])->middleware(['disable'])->name('portfolio');
Route::get('/ateliers', [WorkshopController::class, 'workshops'])->middleware(['disable'])->name('workshops');
Route::get('/ateliers/{workshop}', [WorkshopController::class, 'workshop'])->middleware(['disable'])->name('workshop');
Route::get('/panier', [ShopController::class, 'cart'])->name('cart');
Route::get('/verify-account', [SecurityController::class, 'verifyAccount'])->name('verify-account');
Route::get('/mentions-legales', [InformationController::class, 'mentions'])->name('mentions');
Route::get('/forgot-password', [SecurityController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [SecurityController::class, 'forgotPasswordStore'])->name('forgot-password.store');
Route::get('/reset-password', [SecurityController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [SecurityController::class, 'resetPasswordStore'])->name('password.reset.store');

require __DIR__.'/api.php';
require __DIR__.'/auth.php';
