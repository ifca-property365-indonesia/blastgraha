<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\DashboardController as Dashboard;
use App\Http\Controllers\InvoiceController as Invoice;
use App\Http\Controllers\InvoiceWhatsAppHistoryController as InvoiceWhatsAppHistory;
use App\Http\Controllers\ProcessInvoiceController as ProcessInvoice;
use App\Http\Controllers\PaymentHistoryController as PaymentHistory;
use App\Http\Controllers\MessageController as Message;
use App\Http\Controllers\Admin\EmailConfigurationController as EmailConfiguration;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(Login::class)->group(function () {
    Route::get('/', 'index')->name('/');
    Route::post('/login', 'authenticate')->name('login');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(Message::class)->group(function () {
    Route::get('/payment/{trx_number}', 'show');
    Route::get('/process-payment', 'index');
    Route::get('/expired-link', 'expiredLink');
    Route::get('/not-found', 'failedLink');
});

Route::group(['middleware' => ['check-auth', 'revalidate']], function () {
    Route::controller(Dashboard::class)->group(function () {
        Route::get('/dash', 'index')->name('dash');
        Route::get('/dash-whatsapp-quota', 'indexWhatsappQuota')->name('dash.whatsapp.quota');
        Route::post('/dash-whatsapp-get-graph', 'showWhatsappChart')->name('dash.whatsapp.get.graph');
        Route::post('/dash-whatsapp-get-graph-month', 'showWhatsappChartMonth')->name('dash.whatsapp.get.graph.month');
    });

    Route::controller(Invoice::class)->group(function () {
        Route::get('/index-invoice', 'index')->name('index.invoice');
        Route::view('/index-content-mail-invoice', 'content_email.container.invoice');
        Route::post('/table-invoice', 'getTable')->name('table.invoice');
        Route::get('/show-table-invoice-detail/{doc_no}', 'show')->name('show.table.invoice.detail.doc_no');
        Route::post('/delete-invoice', 'destroy')->name('delete.invoice');
        Route::get('/index-popup-send-invoice', 'showPopupSend')->name('index.popup.send.invoice');
        Route::post('/submit-invoice', 'storeMultiPlatform')->name('submit.invoice');
    });

    Route::controller(InvoiceWhatsAppHistory::class)->group(function () {
        Route::get('/index-history-whatsapp-invoice', 'index')->name('index.history.whatsapp.invoice');
        Route::post('/table-history-whatsapp-invoice-success', 'getTableSuccess')->name('table.history.whatsapp.invoice.success');
        Route::post('/table-history-whatsapp-invoice-failed', 'getTableFailed')->name('table.history.whatsapp.invoice.failed');
        Route::get('/show-table-history-whatsapp-invoice-detail/{row_id}', 'show')->name('show.table.history.whatsapp.invoice.detail.row_id');
        Route::post('/submit-resend-invoice-whatsapp', 'store')->name('submit.resend.invoice.whatsapp');
    });

    Route::controller(ProcessInvoice::class)->group(function () {
        Route::get('/index-invoice-process', 'index')->name('index.invoice.process');
        Route::post('/table-invoice-process', 'getTable')->name('table.invoice.process');
        Route::post('/delete-invoice-process', 'destroy')->name('delete.invoice.process');
        Route::post('/submit-invoice-to-payment', 'store')->name('submit.invoice.to.payment');
    });

    Route::controller(PaymentHistory::class)->group(function () {
        Route::get('/index-payment-history', 'index')->name('index.payment.history');
        Route::post('/table-payment-history', 'getTable')->name('table.payment.history');
    });

    Route::controller(EmailConfiguration::class)->group(function () {
        Route::get('/index-config', 'index')->name('index.config');
        Route::get('/show-config', 'show')->name('show.config');
        Route::post('/submit-config', 'store')->name('submit.config');
    });
});