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