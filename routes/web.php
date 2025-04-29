<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('stations.index');
});

Route::controller(AuthController::class)->group(function (){

    Route::get('/login','showLogin')->name('loginView');
    Route::post('/login','login')->name('login');
    Route::get('/register','showRegister')->name('registerView');
    Route::post('/register','register')->name('register');
    Route::post('/logout','logout')->name('logout');

});


Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
Route::get('/stations/share', [StationController::class, 'create'])->name('stations.create')->middleware('auth');
Route::post('/stations', [StationController::class, 'store'])->name('stations.store');
// In web.php
Route::post('/stations/{station}/like', [StationController::class, 'toggleLike'])->middleware('auth');
