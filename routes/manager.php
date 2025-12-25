<?php

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\OrderController;
use App\Http\Controllers\Manager\PagesController;
use App\Http\Controllers\Manager\ProductController;
use App\Http\Controllers\Cashier\ClientController as CashierClientController;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;
use App\Http\Controllers\Cashier\OrderController as CashierOrderController;
use App\Http\Controllers\Cashier\SmsTemplateController as CashierSmsTemplateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'manager'])->prefix('manager')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('manager.dashboard');

    Route::get('/orders', [OrderController::class, 'orders'])->name('manager.orders');
    Route::get('/orders-peending', [OrderController::class, 'orderspeending'])->name('manager.orders-peending');
    Route::get('/orders-confirmed', [OrderController::class, 'ordersconfirmed'])->name('manager.orders-confirmed');
    Route::get('/orders-cancelled', [OrderController::class, 'orderscancelled'])->name('manager.orders-cancelled');
    Route::get('/orders-delivered', [OrderController::class, 'ordersdelivered'])->name('manager.orders-delivered');
    Route::get('/orders-sended', [OrderController::class, 'orderssended'])->name('manager.orders-sended');
    Route::get('/order-details/{id}', [OrderController::class, 'orderdetails'])->name('manager.order-details');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('manager.orders.update-status');
    Route::post('/orders/{order}/deliver', [OrderController::class, 'assignDeliver'])->name('manager.orders.assign-deliver');
    Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('manager.order-destroy');

    Route::get('/products', [ProductController::class, 'products'])->name('manager.products');
    Route::get('/peending-products', [ProductController::class, 'peendingproducts'])->name('manager.peending-products');
    Route::get('/products-not-stock', [ProductController::class, 'productsnotstock'])->name('manager.products-not-stock');

    Route::get('/sms-page', [PagesController::class, 'smspage'])->name('manager.sms-page');
    Route::post('/onesms', [PagesController::class, 'onesms'])->name('manager.onesms');
    Route::post('/sms-many', [PagesController::class, 'smsmany'])->name('manager.sms-many');
    Route::post('/sms-clients', [PagesController::class, 'storeSmsClient'])->name('manager.sms-clients.store');
    Route::patch('/sms-clients/{user}/toggle', [PagesController::class, 'toggleSmsClient'])->name('manager.sms-clients.toggle');

    Route::prefix('cashier')->name('manager.cashier.')->group(function () {
        Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [CashierOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [CashierOrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [CashierOrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [CashierOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [CashierOrderController::class, 'updateStatus'])->name('orders.status');
        Route::post('/orders/{order}/sms', [CashierOrderController::class, 'sendSms'])->name('orders.sms');

        Route::get('/clients', [CashierClientController::class, 'index'])->name('clients.index');
        Route::post('/clients', [CashierClientController::class, 'store'])->name('clients.store');

        Route::get('/sms-templates', [CashierSmsTemplateController::class, 'index'])->name('sms-templates.index');
        Route::post('/sms-templates', [CashierSmsTemplateController::class, 'store'])->name('sms-templates.store');
        Route::patch('/sms-templates/{template}', [CashierSmsTemplateController::class, 'update'])->name('sms-templates.update');
        Route::delete('/sms-templates/{template}', [CashierSmsTemplateController::class, 'destroy'])->name('sms-templates.destroy');
    });
});
