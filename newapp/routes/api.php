<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::middleware('auth:sanctum')
    ->prefix('api/products')
    ->group(function () {
        Route::delete('/{product}', [ProductController::class, 'delete'])->name('api.products.delete');
    });