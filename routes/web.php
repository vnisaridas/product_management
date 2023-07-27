<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ProductController;

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

Route::group(['middleware' => 'auth' ] , function() {
    //Route::get('/dashboard', function () { return view('dashboard');  })->name('dashboard');
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products-create', [ProductController::class, 'create'])->name('create_product');
    Route::post('/products-store', [ProductController::class, 'store'])->name('product_store');
    Route::post('/products-image', [ProductController::class, 'store_image'])->name('store_image');

    Route::get('/products-edit/{id}', [ProductController::class, 'edit'])->name('edit_product');

    Route::post('/products-update', [ProductController::class, 'update'])->name('update_product');

    Route::get('/products-delete/{id}', [ProductController::class, 'destroy'])->name('delete_product');
});


Auth::routes();
