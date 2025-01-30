<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/services', [App\Http\Controllers\HomeController::class, 'services'])->name('services');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

Route::group(['prefix' => 'products'], function () {
//products
Route::get('/product-single{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('product.single');

Route::post('/product-single{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('add.cart');

Route::get('/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart')->middleware('auth:web');

Route::get('/cart-delete/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');
//checkout
Route::post('/prepare-checkout', [App\Http\Controllers\Products\ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');

Route::get('/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->name('checkout');

Route::post('/checkout', [App\Http\Controllers\Products\ProductsController::class, 'storeCheckout'])->name('process.checkout');
//pay and success
//Route::get('products/pay', [App\Http\Controllers\Products\ProductsController::class, 'payWithPaypal'])->name('products.pay')->Middleware('check.for.price');

Route::get('/success', [App\Http\Controllers\Products\ProductsController::class, 'success'])->name('products.pay.success');
// ->Middleware('check.for.price')
//booking
Route::post('/booking', [App\Http\Controllers\Products\ProductsController::class, 'BookTables'])->name('booking.tables');
//menu
Route::get('/menu', [App\Http\Controllers\Products\ProductsController::class, 'menu'])->name('products.menu');
});
Route::group(['prefix' => 'users'], function () {
//users pages
Route::get('/orders', [App\Http\Controllers\Users\UsersController::class, 'displayOrders'])->name('users.orders')->middleware('auth:web');
Route::get('/bookings', [App\Http\Controllers\Users\UsersController::class, 'displayBookings'])->name('users.bookings')->middleware('auth:web');
//write review
Route::get('/write-reviews', [App\Http\Controllers\Users\UsersController::class, 'writeReview'])->name('write.reviews')->middleware('auth:web');
Route::post('/write-reviews', [App\Http\Controllers\Users\UsersController::class, 'processWriteReview'])->name('process.write.review')->middleware('auth:web');
});

Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login');
// ->Middleware('check.for.auth')
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');
Route::group(['prefix' => 'admin' , 'middleware' => 'auth:admin'], function () {
Route::get('/index', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admin.dashboard');
//admin section
Route::get('/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'displayAllAdmins'])->name('all.admins');
Route::get('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('create.admins');
Route::post('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('store.admins');
});