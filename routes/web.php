<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/about', [AboutController::class, 'index']);

Route::get('/cart', [CartController::class, 'index']);

Route::get('/contact', [ContactController::class, 'index']);

Route::get('/profile', [ProfileController::class, 'index']);