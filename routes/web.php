<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryManagerController;
use App\Http\Controllers\Admin\CommentManagerController;
use App\Http\Controllers\Admin\OrderManagerController;
use App\Http\Controllers\Admin\ProductManagerController;
use App\Http\Controllers\Admin\ContactManagerController;
use App\Http\Controllers\Admin\DashboardManagerController;
use App\Http\Controllers\Admin\StatisticalManagerController;
use App\Http\Controllers\Client\CartController;
//client
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ContactController;

Route::resource('profile', ProfileController::class)->names([
    'index'   => 'profile.index',
]);

Route::resource('contact', ContactController::class)->names([
    'store' =>'contact.store',
]);

Route::get('/', [HomeController::class, 'index'])->name('users.home');

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

Route::get('/shoping-cart', [CartController::class, 'showCart'])->name('users.shoping-cart');
Route::patch('/shoping-cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');


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

Route::get('/about-us',function(){
    return view('users.pages.about-us');
});



// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Category Routes
    Route::resource('categories', CategoryManagerController::class)->names([
        'index'   => 'category.index',
        'create'  => 'category.create',
        'store'   => 'category.store',
        'show'    => 'category.show',
        'edit'    => 'category.edit',
        'update'  => 'category.update',
        'destroy' => 'category.destroy',
    ]);

    // Order Routes
    Route::resource('orders', OrderManagerController::class)->names([
        'index'   => 'order.index',
        'create'  => 'order.create',
        'store'   => 'order.store',
        'show'    => 'order.show',
        'edit'    => 'order.edit',
        'update'  => 'order.update',
        'destroy' => 'order.destroy',
    ]);

    // Product Routes
    Route::resource('products', ProductManagerController::class)->names([
        'index'   => 'product.index',
        'create'  => 'product.create',
        'store'   => 'product.store',
        'show'    => 'product.show',
        'edit'    => 'product.edit',
        'update'  => 'product.update',
        'destroy' => 'product.destroy',
    ]);

    // Comment Routes
    Route::resource('comments', CommentManagerController::class)->names([
        'index'   => 'comment.index',
        'create'  => 'comment.create',
        'store'   => 'comment.store',
        'show'    => 'comment.show',
        'edit'    => 'comment.edit',
        'update'  => 'comment.update',
        'destroy' => 'comment.destroy',
    ]);

    // Contact Routes
    Route::resource('contacts', ContactManagerController::class)->names([
        'index'   => 'contact.index',
        'create'  => 'contact.create',
        'store'   => 'contact.store',
        'show'    => 'contact.show',
        'edit'    => 'contact.edit',
        'update'  => 'contact.update',
        'destroy' => 'contact.destroy',
    ]);
    

    // Dashboard Routes
    Route::get('dashboard', [DashboardManagerController::class, 'index'])->name('dashboard.index');

    // Statistical Routes
    Route::get('statistics', [StatisticalManagerController::class, 'index'])->name('statistics.index');
    Route::get('statistics/sales', [StatisticalManagerController::class, 'sales'])->name('statistics.sales');
    Route::get('statistics/products', [StatisticalManagerController::class, 'products'])->name('statistics.products');
});
