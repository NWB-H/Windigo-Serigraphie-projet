<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/authenticate',[AuthController::class,'authenticate'])->name('authenticate');//->middleware(['verified']);
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/alexis', [TestController::class, 'alexis'])->name('alexis');
