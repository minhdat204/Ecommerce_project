<?php

use Illuminate\Support\Facades\Route;

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
