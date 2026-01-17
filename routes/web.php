<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('Home');

Route::get('/product/{id}', [IndexController::class, 'show']);

Route::get('/category/product/{id}', [IndexController::class, 'show']);

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/about', [AboutController::class, 'index']);

Route::get('/contact', [ContactController::class, 'index']);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/increase', [CartController::class, 'increase'])->name('cart.increase');

Route::post('/cart/decrease', [CartController::class, 'decrease'])->name('cart.decrease');

Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/add-to-cart/{id}', [CartController::class, 'add'])
    ->name('cart.add');

Route::get('/orders', [OrdersController::class, 'index']);

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::get('/category/{id}', [CategoryController::class, 'show']);

Route::get('/profile', [ProfileController::class, 'index']);

Route::get('/auth/register', [AuthController::class, 'registerPage'])->name('RegisterPage');

Route::post('/registerSave', [AuthController::class, 'register'])->name('RegisterSave');

Route::get('/auth/login', [AuthController::class, 'loginPage'])->name('LoginPage');

Route::post('/loginMatcher', [AuthController::class, 'login'])->name('loginMatcher');

Route::get('/logout', [AuthController::class, 'logout'])->name('Logout');

// Admin Side

Route::get('/admin/index', [AdminIndexController::class, 'index'])->name('AdminHome');

Route::get('/admin/profile', [AdminProfileController::class, 'index']);

Route::get('/admin/categories', [AdminCategoriesController::class, 'index'])->name('admin.categories');

Route::post('/admin/categories/add', [AdminCategoriesController::class, 'add'])->name('categories.add');

Route::get('/admin/products', [AdminProductsController::class, 'index'])->name('admin.products');

Route::post('/admin/products/add', [AdminProductsController::class, 'add'])->name('products.add');

Route::get('/admin/orders', [AdminOrdersController::class, 'index']);

Route::put('/orders/{order}/payment-status', [AdminOrdersController::class, 'updatePaymentStatus'])
    ->name('orders.updatePaymentStatus');

Route::put('/orders/{order}/order-status', [AdminOrdersController::class, 'updateOrderStatus'])
    ->name('orders.updateOrderStatus');

Route::get('/admin/settings', [AdminSettingsController::class, 'index']);

Route::post('/admin/settings/update', [AdminSettingsController::class, 'update'])->name('settings.update');

Route::get('/admin/users', [AdminUsersController::class, 'index']);

Route::get('/admin/auth/login', [AdminAuthController::class, 'loginPage'])->name('AdminLoginPage');

Route::get('/admin/auth/register', [AdminAuthController::class, 'registerPage'])->name('AdminRegisterPage');

Route::post('/AdminRegisterSave', [AdminAuthController::class, 'register'])->name('AdminRegisterSave');

Route::post('/AdminloginMatcher', [AdminAuthController::class, 'login'])->name('AdminloginMatcher');

Route::get('/AdminLogout', [AdminAuthController::class, 'logout'])->name('AdminLogout');