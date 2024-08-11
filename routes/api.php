<?php

use App\Http\Controllers\MonnifyPaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/transferFunds', [MonnifyPaymentController::class, 'sendFunds']);
Route::post('/receive-funds', [MonnifyPaymentController::class, 'receiveFunds']);
Route::post('/sell-airtime', [MonnifyPaymentController::class, 'sellAirtime']);
Route::post('/sell-data', [MonnifyPaymentController::class, 'sellData']);
