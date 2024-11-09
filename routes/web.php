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
