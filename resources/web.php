<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Seller\MoyskladController;
use App\Http\Controllers\Web\PagesController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/verification', [AuthController::class, 'verificationpost'])->name('verificationpost');
    Route::post('/loginpost', [AuthController::class, 'loginpost'])->name('loginpost');
});
Route::group(['middleware' => 'auth'], function () {
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/my-orders', [WebController::class, 'myorders'])->name('my-orders');
    Route::post('/cancel-order/{id}', [WebController::class, 'cancelorder'])->name('cancel-order');

    Route::get('/favorites', [PagesController::class, 'favorites'])->name('favorites');
    Route::get('/profile', [PagesController::class, 'profile'])->name('profile');
});
Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/filters', [PagesController::class, 'filters'])->name('filters');
Route::get('/search', [PagesController::class, 'search'])->name('search');
Route::get('/policy', [PagesController::class, 'policy'])->name('policy');
Route::get('/support', [PagesController::class, 'support'])->name('support');

Route::get('details/{id}', [PagesController::class, 'details'])->name('details');

// Route::get('/verification', [PagesController::class, 'verification'])->name('verification');




//Become a seller
Route::get('/become-a-seller', [WebController::class, 'becomeaseller'])->name('become-a-seller');
Route::post('/seller-register', [WebController::class, 'sellerregister'])->name('seller-register');
Route::get('/shopcart', [PagesController::class, 'shopcart'])->name('shopcart');
Route::get('/sellers', [PagesController::class, 'sellers'])->name('all-sellers');
Route::get('/seller-page/{id}', [PagesController::class, 'sellerpage'])->name('page-seller');
Route::get('/discounted-products', [PagesController::class, 'discountedproducts'])->name('discounted-products');
Route::post('/order-verification', [PagesController::class, 'orderverification'])->name('order-verification');

Route::get('/order-verify', [PagesController::class, 'orderverify'])->name('order-verify');
Route::get('/checkout/{id}', [PagesController::class, 'checkout'])->name('checkout');
Route::post('/checkout-post', [PagesController::class, 'checkoutpost'])->name('checkout-post');
