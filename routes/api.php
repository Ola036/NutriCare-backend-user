<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\ResetPasswordController;

// GUEST
Route::post('/login',       [LoginController::class, 'login']);
Route::post('/register',    [RegisterController::class, 'register']);

// USER
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/data',     DataController::class);

    // Authentication
    Route::post('/logout',  [LoginController::class, 'logout']);
    Route::post('reset',    [ResetPasswordController::class, 'reset']);

    // Profile && Settings
    Route::get('/profile',  [ProfileController::class, 'show']);
    Route::put('/profile',  [ProfileController::class, 'update']);
});
