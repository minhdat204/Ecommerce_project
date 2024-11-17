<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatisticalController;

Route::get('/', function () {
    return view('users.pages.home');
})->name('users.home');
Route::get('/shop', function () {
    return view('users.pages.shop');
})->name('users.shop');

Route::get('/blog', function () {
    return view('users.pages.blog');
})->name('users.blog');

Route::get('/contact', function () {
    return view('users.pages.contact');
})->name('users.contact');

Route::get('/shop-details', function () {
    return view('users.pages.shop-details');
})->name('users.shop_details');

Route::get('/shoping-cart', function () {
    return view('users.pages.shoping-cart');
})->name('users.shoping-cart');

Route::get('/checkout', function () {
    return view('users.pages.checkout');
})->name('users.checkout');
// admin
Route::get('/administrator', function () {
    return view('admin.pages.category'); // giao diện mẫu = Category
})->name('dashboard');

Route::get('/mau', function () {
    return view('admin.pages.category'); // giao diện mẫu = Category
})->name('mau');



Route::resource('dashboard', DashboardController::class)->names([
    'index'   => '',
    'create'  => '',
    'store'   => '',
    'show'    => '',
    'edit'    => '',
    'update'  => '',
    'destroy' => '',
]);
Route::resource('categories', CategoryController::class)->names([
    'index'   => '',
    'create'  => '',
    'store'   => '',
    'show'    => '',
    'edit'    => '',
    'update'  => '',
    'destroy' => '',
]);
Route::resource('comments', CommentController::class)->names([
    'index'   => '',
    'create'  => '',
    'store'   => '',
    'show'    => '',
    'edit'    => '',
    'update'  => '',
    'destroy' => '',
]);
Route::resource('contacts', ContactController::class)->names([
    'index'   => '',
    'create'  => '',
    'store'   => '',
    'show'    => '',
    'edit'    => '',
    'update'  => '',
    'destroy' => '',
]);
Route::resource('orders', OrderController::class)->names([
    'index'   => '',
    'create'  => '',
    'store'   => '',
    'show'    => '',
    'edit'    => '',
    'update'  => '',
    'destroy' => '',
]);
Route::resource('products', ProductController::class)->names([
    'index'   => '',
    'create'  => '',
    'store'   => '',
    'show'    => '',
    'edit'    => '',
    'update'  => '',
    'destroy' => '',
]);
Route::resource('statisticals', StatisticalController::class)->names([
    'index'   => '',
    'create'  => '',
    'store'   => '',
    'show'    => '',
    'edit'    => '',
    'update'  => '',
    'destroy' => '',
]);
