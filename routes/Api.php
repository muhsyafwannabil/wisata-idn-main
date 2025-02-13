<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\ProductController;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/cari_user', [AuthController::class, 'cari_user']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('order', OrderController::class);
    Route::prefix('kategori')->group(function(){
        Route::get('/data', [KategoriController::class, 'index']);
        Route::post('/tambah', [KategoriController::class, 'create']);
        Route::get('/hapus/{id}', [KategoriController::class, 'delete']);
        Route::post('/update/{id}', [KategoriController::class, 'update']);

    });

    // Route::apiResource('/kategori',[KategoriController::class]);
});
