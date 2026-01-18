<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('', [ProductController::class, 'store'])->name('products.store');
})->prefix('api/products');