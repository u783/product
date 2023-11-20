<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Livewire\ProductList;
use App\Http\Controllers\ProductsSearchController;
use App\Http\Controllers\purchaseController;


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

Route::get('/', function () {
    return view('welcome');
});

//商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

//商品作成フォーム表示
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

//商品作成
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

//商品詳細
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

//商品編集フォーム表示
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

//商品更新
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

//商品削除
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

//商品検索
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

//Route::get('/products', \App\Http\Livewire\ProductList::class);
Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');

Auth::routes();

Route::get('/home', [ProductController::class, 'index'])->name('home')->middleware('auth');

