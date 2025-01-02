<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryManagerController;
use App\Http\Controllers\Admin\CommentManagerController;
use App\Http\Controllers\Admin\OrderManagerController;
use App\Http\Controllers\Admin\ProductManagerController;
use App\Http\Controllers\Admin\ContactManagerController;
use App\Http\Controllers\Admin\DashboardManagerController;
use App\Http\Controllers\Admin\StatisticalManagerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
//client
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ReviewController;

Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

Route::resource('profile', ProfileController::class)->names([
    'index'   => 'profile.index',
]);
Route::get('/orders/{id}', [OrderController::class, 'orderDetail'])->name('orders.detail');
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

Route::resource('contact', ContactController::class)->names([
    'store' => 'contact.store',
]);

Route::get('/', [HomeController::class, 'index'])->name('users.home');

Route::get('/shop', [ProductController::class, 'index'])->name('users.shop');
Route::get('/shop/category/{slug}', [ProductController::class, 'showCategory'])->name('shop.category');

Route::get('/shop-detail/{slug}', [ProductController::class, 'show'])->name('users.shop_details');
Route::get('/favorite/{id_sanpham}', [ProductController::class, 'favorite'])->name('users.shop_details.favorite');
Route::get('/blogs', [BlogController::class, 'index'])->name('users.blogs');
Route::get('blogs/{slug}', [BlogController::class, 'show'])->name('user.blog_details');

Route::get('/contact', function () {
    return view('users.pages.contact');
})->name('users.contact');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
// admin
Route::get('/administrator', function () {
    return view('admin.pages.category'); // giao diện mẫu = Category
})->name('dashboard');

Route::get('/mau', function () {
    return view('admin.pages.category'); // giao diện mẫu = Category
})->name('mau');

Route::get('/about-us', function () {
    return view('users.pages.about-us');
});


Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::post('resend-otp', [ForgotPasswordController::class, 'sendResetLink'])->name('password.resend-otp');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Cart routes
Route::group(['prefix' => 'cart', 'middleware' => 'auth'], function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/items', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/items/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/items/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clearCart'])->name('cart.clear');
})->name('cart.');

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



    Route::patch('products/{product}/hide', [ProductManagerController::class, 'hide'])->name('product.hide');

    // Dashboard Routes
    Route::get('dashboard', [DashboardManagerController::class, 'index'])->name('dashboard.index');
    Route::put('dashboard/website-info', [DashboardManagerController::class, 'updateWebsiteInfo'])
        ->name('dashboard.update-website-info');
    // Statistical Routes
    Route::get('statistics', [StatisticalManagerController::class, 'sales'])->name('statistics.index');
    Route::get('statistics/sales', [StatisticalManagerController::class, 'sales'])->name('statistics.sales');
    Route::get('statistics/products', [StatisticalManagerController::class, 'productSales'])->name('statistics.productSales');
});
