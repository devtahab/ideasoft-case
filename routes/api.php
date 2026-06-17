<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

Route::get('/customers', [CustomerController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);

Route::post('/orders/preview', [OrderController::class, 'preview']);

Route::get('/customers/{id}/orders', [CustomerController::class, 'orders']);