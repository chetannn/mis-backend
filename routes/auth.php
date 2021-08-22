<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TokenController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest');

Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class)->middleware('auth');
