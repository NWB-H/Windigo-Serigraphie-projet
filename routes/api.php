<?php

use App\Http\Controllers\Api\OptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware('auth:sanctum')
    ->prefix('api/products')
    ->group(function () {
        Route::delete('/{product}', [ProductController::class, 'delete'])->name('api.products.delete');
    });

Route::middleware('auth:sanctum')
    ->prefix('api/categories')
    ->group(function () {
        Route::delete('/{category}', [CategoryController::class, 'delete'])->name('api.categories.delete');
    });

Route::middleware('auth:sanctum')
    ->prefix('api/options')
    ->group(function () {
        Route::delete('/{option}', [OptionController::class, 'delete'])->name('api.options.delete');
    });