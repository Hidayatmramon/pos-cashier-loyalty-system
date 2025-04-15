<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['isLogin', 'cekRole:admin'])->group(function () {
    Route::prefix('/dashboard')->group(function () {
    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('index');
        Route::get('/create', [LoginController::class, 'create'])->name('create');
        Route::post('/create-post', [LoginController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LoginController::class, 'edit'])->name('edit');
        Route::patch('/edit-post/{id}', [LoginController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [LoginController::class, 'destroy'])->name('destroy');
    });

});

});
Route::middleware(['isLogin'])->group(function () {
    Route::prefix('/dashboard')->group(function () {
    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');

Route::prefix('/product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/create-post', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::patch('/edit-post/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });


Route::prefix('/sale')->name('sale.')->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('index');
    Route::get('/detail-print/print/{id}', [SaleController::class, 'print'])->name('print');
    });
 });

});

Route::middleware(['isLogin', 'cekRole:cashier'])->group(function () {
    Route::prefix('/dashboard')->group(function () {
    Route::prefix('/sale')->name('sale.')->group(function () {
        Route::get('/create', [SaleController::class, 'create'])->name('create');
        Route::get('/create/member/{saleId}', [SaleController::class, 'createMember'])->name('create_member');
        Route::post('/create/post', [SaleController::class, 'store'])->name('store');
        Route::post('/create/customer', [SaleController::class, 'storeCustomer'])->name('store.customer');
        Route::post('/create/detail-shop/store', [SaleController::class, 'detailShop'])->name('store.detail');
        Route::get('/export-excel', [SaleController::class, 'export'])->name('export');
        Route::get('/detail-print/{id}', [SaleController::class, 'showPrint'])->name('show.print');
        Route::delete('destroy/{id}', [SaleController::class, 'destroy'])->name('destroy');
    });
    });
});

Route::middleware(['isGuest'])->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/login/post', [LoginController::class, 'auth'])->name('auth');
});


Route::get('/logout', [LoginController::class, 'logout'])->name('logout');