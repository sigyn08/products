<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// 商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品追加フォーム
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// 商品登録処理
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// 商品編集フォーム
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// 商品更新処理
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// 商品削除処理
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
