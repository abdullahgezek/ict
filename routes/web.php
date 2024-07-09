<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

});

Route::group([
    'prefix' => 'v1',
], function () {
    Route::get('orders', [\App\Http\Controllers\Api::class, 'orders'])->name('get-orders');

    Route::get('product/{productId}', [\App\Http\Controllers\ProductController::class, 'get'])->name('get-product');
    Route::put('product/{productId}', [\App\Http\Controllers\ProductController::class, 'update'])->name('update-product')->middleware(\App\Http\Middleware\VerifyCsrfToken::class);;
    Route::post('product', [\App\Http\Controllers\ProductController::class, 'store'])->name('create-product');
    Route::delete('product/{productId}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy-product');


    Route::get('/order-counts', [\App\Http\Controllers\ReportsController::class, 'getOrderCounts']);
    Route::get('/most-used-products-out-of-stock', [\App\Http\Controllers\ReportsController::class, 'getMostUsedProductsOutOfStock']);
});