<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.index');
})->name('home');
Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/blog', function () {
    return view('pages.blog');
});
Route::get('/cart', function () {
    return view('pages.cart');
});
Route::get('/checkout', function () {
    return view('pages.checkout');
});
Route::get('/contact', function () {
    return view('pages.contact');
});
Route::get('/services', function () {
    return view('pages.services');
});
Route::get('/shop', function () {
    return view('pages.shop');
});
Route::get('/thankyou', function () {
    return view('pages.thankyou');
});
Route::get('/index', function () {
    return view('content.index');
});

Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');


Route::middleware('guest')->group(function(){
    Route::get('/register', [AuthController::class, 'create'])->name('user.create');
    Route::post('/register', [AuthController::class, 'store'])->name('user.store');
    
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('login.auth');
    
    Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget.request');
    Route::post('/forget-password', [AuthController::class, 'forgetEmail'])->name('forget.email');
    Route::get('/reset-password/{email}/{token}', [AuthController::class, 'resetPasswordCreate'])->middleware('signed')
    ->name('forget.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPasswordStore'])->name('reset.password');

});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/category/creates', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/category', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/category', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/category/{category}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::get('/brand/creates', [BrandController::class, 'create'])->name('brands.create');
Route::post('/brand', [BrandController::class, 'store'])->name('brands.store');
Route::get('/brand', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
Route::put('/brand/{id}/update', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brand/{brand}/destroy', [BrandController::class, 'destroy'])->name('brands.destroy');
Route::get('/index', [WebsiteController::class, 'index'])->name('index');

Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.remove');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
////checkout///
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/place-order', [CartController::class, 'placeorder'])->name('cart.placeorder');
Route::get('/checkout-cancel', [CartController::class, 'checkoutCancel'])->name('checkout.cancel');
Route::get('/checkout/success', [CartController::class, 'checkoutSuccess'])->name('checkout.success');
Route::get('/thankyou', function () {
    return view('thankyou');
})->name('thankyou');
