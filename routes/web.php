<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/set-user-rate', [App\Http\Controllers\HomeController::class, 'setUserRate'])->name('set-user-rate');
