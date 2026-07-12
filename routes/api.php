<?php

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
// Import root controller utama
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute Webhook Callback Midtrans
Route::post('/midtrans/callback', [OrderController::class, 'callback']);
