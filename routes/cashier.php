<?php

use App\Http\Controllers\Cashier\DashboardController;
use App\Http\Controllers\Cashier\ClientController;
use App\Http\Controllers\Cashier\OrderController;
use App\Http\Controllers\Cashier\SmsTemplateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'cashier'])->prefix('cashier')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('cashier.dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('cashier.orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('cashier.orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('cashier.orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('cashier.orders.show');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('cashier.orders.status');
    Route::post('/orders/{order}/sms', [OrderController::class, 'sendSms'])->name('cashier.orders.sms');

    Route::get('/clients', [ClientController::class, 'index'])->name('cashier.clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('cashier.clients.store');

    Route::get('/sms-templates', [SmsTemplateController::class, 'index'])->name('cashier.sms-templates.index');
    Route::post('/sms-templates', [SmsTemplateController::class, 'store'])->name('cashier.sms-templates.store');
    Route::patch('/sms-templates/{template}', [SmsTemplateController::class, 'update'])->name('cashier.sms-templates.update');
    Route::delete('/sms-templates/{template}', [SmsTemplateController::class, 'destroy'])->name('cashier.sms-templates.destroy');
});
