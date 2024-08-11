<?php

use App\Http\Controllers\MonnifyPaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payment/initiate', [MonnifyPaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('/payment/initiate', [MonnifyPaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('/payment/callback', [MonnifyPaymentController::class, 'paymentCallback'])->name('payment.callback');
Route::post('/transfer-funds', [MonnifyPaymentController::class, 'transferFunds'])->name('transfer.funds');
Route::post('/sell-airtime', [MonnifyPaymentController::class, 'sellAirtime'])->name('sell.airtime');
Route::post('/sell-data', [MonnifyPaymentController::class, 'sellData'])->name('sell.data');
Route::post('/pay-utility-bills', [MonnifyPaymentController::class, 'payUtilityBills'])->name('pay.utility.bills');
