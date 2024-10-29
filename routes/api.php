<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;

// GUEST
Route::post('/login',       [LoginController::class, 'login']);
Route::post('/register',    [RegisterController::class, 'register']);

// USER
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',  [LoginController::class, 'logout']);
});
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('');
