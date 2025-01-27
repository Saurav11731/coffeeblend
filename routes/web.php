<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//products
Route::get('products/product-single{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('product.single');

Route::post('products/product-single{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('add.cart');

Route::get('products/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart');

Route::get('products/cart-delete/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');
//checkout
Route::post('products/prepare-checkout', [App\Http\Controllers\Products\ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');

Route::get('products/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->name('checkout');

Route::post('products/checkout', [App\Http\Controllers\Products\ProductsController::class, 'storeCheckout'])->name('process.checkout');
//pay and success
//Route::get('products/pay', [App\Http\Controllers\Products\ProductsController::class, 'payWithPaypal'])->name('products.pay')->Middleware('check.for.price');

Route::get('products/success', [App\Http\Controllers\Products\ProductsController::class, 'success'])->name('products.pay.success');
// ->Middleware('check.for.price')
//booking
Route::post('products/booking', [App\Http\Controllers\Products\ProductsController::class, 'BookTables'])->name('booking.tables');
//menu
Route::get('products/menu', [App\Http\Controllers\Products\ProductsController::class, 'menu'])->name('products.menu');

//users pages
Route::get('users/orders', [App\Http\Controllers\Users\UsersController::class, 'displayOrders'])->name('users.orders');
Route::get('users/bookings', [App\Http\Controllers\Users\UsersController::class, 'displayBookings'])->name('users.bookings');
//write review
Route::get('users/write-reviews', [App\Http\Controllers\Users\UsersController::class, 'writeReview'])->name('write.reviews');
Route::post('users/write-reviews', [App\Http\Controllers\Users\UsersController::class, 'processWriteReview'])->name('process.write.review');
