<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RouletteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'getLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('roulette/{rouletteLink:slug}', [RouletteController::class, 'index'])
        ->name('roulette.index');
    Route::post('roulette', [RouletteController::class, 'createNewLink'])
        ->name('roulette.createNewLink');
    Route::post('roulette/{rouletteLink:slug}', [RouletteController::class, 'span'])
        ->name('roulette.span');
    Route::get('roulette/{rouletteLink:slug}/history', [RouletteController::class, 'history'])
        ->name('roulette.history');
});
