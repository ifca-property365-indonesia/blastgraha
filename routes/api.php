<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NotificationCallbackFinpayController as NotificationCallbackFinpay;
use App\Http\Controllers\Api\NotificationCallbackWhatsAppController as NotificationCallbackWhatsApp;
use App\Http\Controllers\Api\InvoiceController as Invoice;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('notification')->group(function () {
    Route::controller(NotificationCallbackFinpay::class)->group(function () {
        Route::post('/payment', 'store');
    });

    Route::controller(NotificationCallbackWhatsApp::class)->group(function () {
        Route::post('/whatsapp', 'store');
    });
});

Route::controller(Invoice::class)->group(function () {
    Route::get('/store-invoice', 'store');
});
