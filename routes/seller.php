<?php

use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\MoyskladController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'seller'])->prefix('seller')->group(function () {
    Route::get('/seller-dashboard', [DashboardController::class, 'sellerdashboard'])->name('seller-dashboard');
    Route::post('/update', [MoyskladController::class, 'moyskladbigupdate'])->name('moyskladbigupdate');
    Route::post('/updatestock', [MoyskladController::class, 'updateStockQuantities'])->name('updateStockQuantities');
    // Products
    Route::get('/products', [ProductController::class, 'products'])->name('all-products-seller');
    Route::get('/peending-products', [ProductController::class, 'peendingproducts'])->name('peending-products-selle');
    Route::get('/products-update', [ProductController::class, 'productsupdate'])->name('update-products-selle');
    Route::get('/products-not-stock', [ProductController::class, 'productsnotstock'])->name('products-not-stock-selle');
    Route::get('/add-product', [ProductController::class, 'addproduct'])->name('add-product-selle');
    Route::get('/edit-product/{id}', [ProductController::class, 'editproduct'])->name('edit-product-selle');
    Route::post('/edit-product-post/{id}', [ProductController::class, 'editproductpost'])->name('edit-product-post-selle');
    Route::post('/add-product-post', [ProductController::class, 'addproductpost'])->name('add-product-post-selle');

    // Orders
    Route::get('/orders', [OrderController::class, 'orders'])->name('orders-seller');
    Route::get('/orders-peending', [OrderController::class, 'orderspeending'])->name('orders-peending-seller');
    Route::get('/orders-confirmed', [OrderController::class, 'ordersconfirmed'])->name('orders-confirmed-seller');
    Route::get('/orders-cancelled', [OrderController::class, 'orderscancelled'])->name('orders-cancelled-seller');
    Route::get('/orders-delivered', [OrderController::class, 'ordersdelivered'])->name('orders-delivered-seller');
    Route::get('/order-details/{id}', [OrderController::class, 'orderdetails'])->name('order-details-seller');

    // Setting
    Route::get('/settings', [MoyskladController::class, 'settings'])->name('seller.settings');
    Route::post('/settings', [MoyskladController::class, 'updateSettings'])->name('seller.updateSettings');
    Route::get('/moysklad/settings', [MoyskladController::class, 'moyskladsettings'])->name('moysklad-settings');
});
