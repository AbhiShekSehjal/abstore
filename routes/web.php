<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
// use App\Http\Controllers\SingleProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);

Route::get('/product/{id}', [IndexController::class, 'show']);

Route::get('/category/product/{id}', [IndexController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/about', [AboutController::class, 'index']);

Route::get('/cart', [CartController::class, 'index']);

Route::get('/category/{id}', [CategoryController::class, 'show']);

// Route::get('/contact', [ContactController::class, 'index']);

Route::get('/profile', [ProfileController::class, 'index']);

// Admin Side

Route::get('/admin/index', [AdminIndexController::class, 'index']);