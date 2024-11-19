<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('server.config')->group(function () {
	Route::any('payments/notification/freekassa', [\App\Http\Controllers\Api\PaymentsController::class, 'freekassa']);
	Route::any('payments/notification/app', [\App\Http\Controllers\Api\PaymentsController::class, 'appCent']);
	Route::any('payments/notification/qiwi', [\App\Http\Controllers\Api\PaymentsController::class, 'qiwi']);
	Route::any('payments/notification/enot', [\App\Http\Controllers\Api\PaymentsController::class, 'enot']);
	Route::any('payments/notification/primepayments', [\App\Http\Controllers\Api\PaymentsController::class, 'primepayments']);
	Route::any('payments/notification/pagseguro', [\App\Http\Controllers\Api\PaymentsController::class, 'pagseguro']);
	Route::any('payments/notification/paymentwall', [\App\Http\Controllers\Api\PaymentsController::class, 'paymentwall']);
});
