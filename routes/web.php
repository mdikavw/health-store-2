<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth'])->group(function ()
{
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update']);


    Route::get('/users/{user:username}/cart', [CartController::class, 'show'])->name('user.cart');

    Route::post('/cart/add', [CartItemController::class, 'store']);
    Route::delete('/cart/delete', [CartItemController::class, 'destroy']);

    Route::post('/products/buy', [OrderController::class, 'buyNow']);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/confirmation', [OrderController::class, 'confirmation']);
    Route::post('/orders/checkout', [OrderController::class, 'checkout']);
    Route::post('/orders/payment', [OrderController::class, 'payment']);
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/{order}/invoice/download', [OrderController::class, 'downloadInvoice'])->name('orders.invoice_download');

    Route::get('/payment/success/{order}', [OrderController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel/{order}', [OrderController::class, 'paymentCancel'])->name('payment.cancel');
});

Route::middleware(['auth', 'admin'])->group(function ()
{
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::delete('/admin/users/{user:username}/delete', [UserController::class, 'destroy']);

    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products/create', [ProductController::class, 'store']);
    Route::get('/admin/products/{product:slug}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('/admin/products/{product:slug}/edit', [ProductController::class, 'update']);
    Route::delete('/admin/products/{product:slug}/delete', [ProductController::class, 'destroy']);

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/categories/create', [CategoryController::class, 'store']);
    Route::get('/admin/categories/{category:slug}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/categories/{category:slug}/edit', [CategoryController::class, 'update']);
    Route::delete('/admin/categories/{category:slug}/delete', [CategoryController::class, 'destroy']);

    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::post('/admin/orders/{order}', [AdminController::class, 'order'])->name('admin.order.show');
    Route::delete('/admin/orders/{order}', [AdminController::class, 'deleteOrder']);
    Route::patch('/admin/orders/{order}/update-status', [AdminController::class, 'updateOrder']);
});
