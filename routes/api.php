<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute API untuk aplikasi Anda.
| Rute-rute ini dimuat oleh RouteServiceProvider dalam grup yang diberi nama "api".
| Nikmati dalam membangun API Anda!
|
*/

// Registrasi pengguna baru
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);

// Login pengguna
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

// Rute-rute yang membutuhkan autentikasi menggunakan middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {
    // Logout pengguna
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    // Daftar menu
    Route::get('/list_menu', [\App\Http\Controllers\Api\MenuController::class, 'index']);

    // Membuat pesanan baru
    Route::post('/order', [\App\Http\Controllers\Api\OrderController::class, 'create']);

    // Mendapatkan semua pesanan
    Route::get('/order', [\App\Http\Controllers\Api\OrderController::class, 'index']);

    // Mendapatkan pesanan spesifik
    Route::get('/order/{orderId}', [\App\Http\Controllers\Api\OrderController::class, 'show']);

    // // Memperbarui pesanan
    // Route::put('/order/{orderId}', [\App\Http\Controllers\Api\OrderController::class, 'update']);

    // Menghapus pesanan
    Route::delete('/order/{orderId}', [\App\Http\Controllers\Api\OrderController::class, 'destroy']);
});
