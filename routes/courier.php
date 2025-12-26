<?php

use App\Http\Controllers\Courier\DashboardController;
use App\Http\Controllers\Courier\OrderController;
use App\Http\Controllers\Courier\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'courier'])->prefix('courier')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('courier.dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('courier.orders');
    Route::get('/archive', [OrderController::class, 'archive'])->name('courier.archive');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('courier.orders.show');
    Route::post('/orders/{order}/received', [OrderController::class, 'markReceived'])->name('courier.orders.received');
    Route::post('/orders/{order}/delivered', [OrderController::class, 'markDelivered'])->name('courier.orders.delivered');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('courier.orders.cancel');

    Route::get('/profile', [ProfileController::class, 'index'])->name('courier.profile');
});
