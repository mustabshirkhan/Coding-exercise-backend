<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\TransactionController;
use App\Http\Controllers\API\v1\PaymentController;

Route::middleware(['auth', 'check.admin.perms'])->group(function () {

    Route::get('/transactions', [TransactionController::class, 'getUserTransactions']);
    Route::get('/transactions/{transactionId}', [TransactionController::class, 'viewTransaction']);
    Route::post('/transactions/create', [TransactionController::class, 'create']);
    Route::post('/payments/record', [PaymentController::class, 'recordPayment']);
    Route::get('/generate-monthly-report', [TransactionController::class, 'generateMonthlyReport']);

});
