<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CatalogueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
// Client frontend
// Catalogue
Route::prefix('catalogue')->name('catalogue.')->group(function (){
    Route::get('/', [CatalogueController::class, 'index'])->name('index');
    Route::get('/category/{category}', [CatalogueController::class, 'category'])->name('category');
    Route::get('/product/{product}', [CatalogueController::class, 'product'])->name('product');
});

// Authentication
Route::prefix('auth')->group(function(){
    Route::get('/login', [LoginController::class, 'index']);
    Route::post('/login', [LoginController::class, 'login']);
});
// Admin frontend
// Administration
// TODO: ADD Authorization middleware
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/', [AdminController::class, 'index']);
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/addproduct', [CartController::class, 'addproduct'])->name('addproduct');
});
