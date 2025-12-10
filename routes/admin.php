<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliverController;
use App\Http\Controllers\Admin\EmpliyoneController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\CouponesController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\FacebookFeedController;
use App\Http\Controllers\Web\MiniatureController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    //Category routes
    Route::get('/categories/{id?}', [CategoryController::class, 'categories'])->name('categories');
    Route::post('/add-category/{id?}', [CategoryController::class, 'addcategory'])->name('add-category');
    Route::post('/home-category/{id}', [CategoryController::class, 'homecategory'])->name('home-category');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'deletecategory'])->name('delete-category');
    //SubCategory routes
    Route::get('/subcategories/{id?}', [CategoryController::class, 'subcategories'])->name('subcategories');
    Route::post('/add-subcategory', [CategoryController::class, 'addsubcategory'])->name('add-subcategory');
    Route::delete('/delete-subcategory/{id}', [CategoryController::class, 'deletesubcategory'])->name('delete-subcategory');

    //Sellers
    Route::get('/sellers', [SellerController::class, 'sellers'])->name('sellers');
    Route::get('/peending-sellers', [SellerController::class, 'peendingsellers'])->name('peending-sellers');
    Route::get('/add-seller', [SellerController::class, 'addseller'])->name('add-seller');
    Route::post('/add-seller-post', [SellerController::class, 'addsellerpost'])->name('add-seller-post');
    Route::get('/show-seller/{id}', [SellerController::class, 'showseller'])->name('show-seller');
    Route::post('/activate-seller/{id}', [SellerController::class, 'activateseller'])->name('activate-seller');
    Route::post('/verify-seller/{id}', [SellerController::class, 'verifyseller'])->name('verify-seller');
    // Products
    Route::get('/products', [ProductController::class, 'products'])->name('all-products');
    Route::get('/peending-products', [ProductController::class, 'peendingproducts'])->name('peending-products');
    Route::get('/products-update', [ProductController::class, 'productsupdate'])->name('update-products');
    Route::get('/products-not-stock', [ProductController::class, 'productsnotstock'])->name('products-not-stock');
    Route::get('/add-product', [ProductController::class, 'addproduct'])->name('add-product');
    Route::get('/edit-product/{id}', [ProductController::class, 'editproduct'])->name('edit-product');
    Route::post('/edit-product-post/{id}', [ProductController::class, 'editproductpost'])->name('edit-product-post');
    Route::post('/add-product-post', [ProductController::class, 'addproductpost'])->name('add-product-post');
    // Deliver Boy
    Route::get('/delivers', [DeliverController::class, 'showDeliveryPersons'])->name('delivers');
    Route::get('/add-deliver', [DeliverController::class, 'adddeliver'])->name('add-deliver');
    Route::get('/show-deliver/{id}', [DeliverController::class, 'showdeliver'])->name('show-deliver');
    Route::post('/add-deliver-post', [DeliverController::class, 'addDeliveryPerson'])->name('add-deliver-post');
    // Empliyone
    Route::get('/add-empliyone/{phone?}', [EmpliyoneController::class, 'addempliyone'])->name('add-empliyone');
    Route::post('/add-empliyone-post', [EmpliyoneController::class, 'addempliyonepost'])->name('add-empliyone-post');
    Route::post('/del-empliyone-post/{id}', [EmpliyoneController::class, 'delempliyonepost'])->name('delempliyonepost');
    Route::get('/empliyones', [EmpliyoneController::class, 'empliyones'])->name('empliyones');
    // Orders
    Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    Route::get('/orders-peending', [OrderController::class, 'orderspeending'])->name('orders-peending');
    Route::get('/orders-confirmed', [OrderController::class, 'ordersconfirmed'])->name('orders-confirmed');
    Route::get('/orders-cancelled', [OrderController::class, 'orderscancelled'])->name('orders-cancelled');
    Route::get('/orders-delivered', [OrderController::class, 'ordersdelivered'])->name('orders-delivered');
    Route::get('/orders-sended', [OrderController::class, 'orderssended'])->name('orders-sended');
    Route::get('/order-details/{id}', [OrderController::class, 'orderdetails'])->name('order-details');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/{order}/deliver', [OrderController::class, 'assignDeliver'])->name('orders.assign-deliver');
    Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('order-destroy');

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin-dashboard');
    //Sms
    Route::get('/sms-page', [PagesController::class, 'smspage'])->name('sms-page');
    Route::post('/onesms', [PagesController::class, 'onesms'])->name('onesms');
    Route::post('/sms-many', [PagesController::class, 'smsmany'])->name('sms-many');
    Route::get('/account', [PagesController::class, 'account'])->name('admin.account');
    Route::post('/account', [PagesController::class, 'updateAccount'])->name('admin.account.update');
    //Coupones
    Route::get('/coupones', [CouponesController::class, 'coupones'])->name('coupones');
    Route::post('/add-coupones', [CouponesController::class, 'addcoupones'])->name('add-coupones');
    Route::delete('/delete-coupones/{id}', [CouponesController::class, 'deletecoupones'])->name('delete-coupones');
    //Coupones
    Route::get('/setting', [TaxController::class, 'setting'])->name('setting');
    Route::post('/tax', [TaxController::class, 'tax'])->name('tax');
    Route::post('/delivery', [TaxController::class, 'delivery'])->name('delivery');
    Route::post('/facebook-feeds', [FacebookFeedController::class, 'index'])->name('facebook-feeds');
    //imageoptomozer
    Route::post('/imageoptomozer', [MiniatureController::class, 'imageoptomozer'])->name('imageoptomozer');
    //Sliders
    Route::get('/sliders', [SliderController::class, 'sliders'])->name('sliders');
    Route::post('/slider-add', [SliderController::class, 'slideradd'])->name('slider-add');
    Route::post('/slider-del/{id}', [SliderController::class, 'sliderdel'])->name('slider-del');
    //cities
    Route::get('/cities', [CityController::class, 'cities'])->name('cities');
    Route::post('/city-add', [CityController::class, 'cityadd'])->name('city-add');
    Route::post('/city-del/{id}', [CityController::class, 'cityrdel'])->name('city-del');
    Route::post('/facebook-feeds', [FacebookFeedController::class, 'index'])->name('facebook-feeds');
    //Truncate
    Route::post('/truncate', [FacebookFeedController::class, 'truncate'])->name('truncate');
});
