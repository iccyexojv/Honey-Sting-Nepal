<?php

use App\Http\Controllers\Api\FraudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/card-payment', [FraudController::class, 'cardPayment']);
Route::get('/transaction-templates', [FraudController::class, 'getTransactionTemplates']);
