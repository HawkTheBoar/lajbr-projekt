<?php
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CatalogueController;
use App\Http\Middleware\AdminRedirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
// Client frontend
Route::get('/', function(){
    return redirect()->route('catalogue.index');
});
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
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    // Protected admin routes
    Route::middleware(AdminRedirect::class)->group(function (){
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/', [AdminController::class, 'index']);
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
    });
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'addProduct'])->name('addproduct');
    Route::post('/remove', [CartController::class, 'removeProduct'])->name('removeproduct');
    Route::post('/cart/empty', [CartController::class, 'emptyCart'])->name('empty');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});

