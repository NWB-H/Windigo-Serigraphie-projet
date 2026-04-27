<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('api/products')
    ->group(function () {
        Route::delete('/{product}', [ProductController::class, 'delete'])->name('api.products.delete');
        Route::delete('/{product}/medias/{media}', [ProductController::class, 'deleteMedia'])->name('api.products.deleteMedia');
        Route::patch('/{product}/medias/{media}/highlighted', [ProductController::class, 'highlightImage'])->name('api.products.highlightImage');
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
