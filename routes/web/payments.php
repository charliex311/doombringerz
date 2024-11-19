<?php

use Illuminate\Support\Facades\Route;

Route::middleware('server.config')->group(function () {
    Route::get('/paypal/status', [\App\Http\Controllers\PaymentsController::class, 'paypalStatus'])->name('paypal.status');
    Route::get('/pagseguro/status', [\App\Http\Controllers\PaymentsController::class, 'pagseguroStatus'])->name('pagseguro.status');
    Route::get('/paymentwall/status', [\App\Http\Controllers\PaymentsController::class, 'paymentwallStatus'])->name('paymentwall.status');
    Route::get('/qiwi/status', [\App\Http\Controllers\PaymentsController::class, 'qiwiStatus'])->name('qiwi.status');
    Route::get('/enot/{method}', [\App\Http\Controllers\PaymentsController::class, 'enotStatus'])->name('enot.status');
    Route::get('/freekassa/{method}', [\App\Http\Controllers\PaymentsController::class, 'freekassaStatus'])->name('freekassa.status');
    Route::get('/primepayments/{method}', [\App\Http\Controllers\PaymentsController::class, 'primepaymentsStatus'])->name('primepayments.status');
});
