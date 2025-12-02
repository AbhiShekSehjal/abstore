<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('Home');

Route::get('product/{id}', [IndexController::class, 'show']);

Route::get('category/product/{id}', [IndexController::class, 'show']);

Route::get('products', [ProductController::class, 'index']);

Route::get('about', [AboutController::class, 'index']);

Route::get('cart', [CartController::class, 'index']);

Route::get('category/{id}', [CategoryController::class, 'show']);

Route::get('profile', [ProfileController::class, 'index']);

Route::get('auth/register', [AuthController::class, 'registerPage'])->name('RegisterPage');

Route::post('registerSave', [AuthController::class, 'register'])->name('RegisterSave');

Route::get('auth/login', [AuthController::class, 'loginPage'])->name('LoginPage');

Route::post('loginMatcher', [AuthController::class, 'login'])->name('loginMatcher');

Route::get('logout', [AuthController::class, 'logout'])->name('Logout');

// Admin Side

Route::get('admin/index', [AdminIndexController::class, 'index'])->name('AdminHome');

Route::get('admin/profile', [AdminProfileController::class, 'index']);

Route::get('admin/categories', [AdminCategoriesController::class, 'index']);

Route::get('admin/products', [AdminProductsController::class, 'index']);

Route::get('admin/auth/login', [AdminAuthController::class, 'loginPage'])->name('AdminLoginPage');

Route::get('admin/auth/register', [AdminAuthController::class, 'registerPage'])->name('AdminRegisterPage');

Route::post('AdminRegisterSave', [AdminAuthController::class, 'register'])->name('AdminRegisterSave');

Route::post('AdminloginMatcher', [AdminAuthController::class, 'login'])->name('AdminloginMatcher');