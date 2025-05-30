<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImagenController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('imagenes', ImagenController::class);
Route::apiResource('categorias', \App\Http\Controllers\Api\CategoriaImagenController::class);
Route::apiResource('ordenes', \App\Http\Controllers\Api\OrderController::class);
Route::apiResource('productos', \App\Http\Controllers\Api\ProductController::class);

Route::get('imagenes/usuario/{userId}', [ImagenController::class, 'getImagesByUser']);

// User API Routes
Route::apiResource('users', UserController::class)->except(['create', 'edit']); // Use apiResource for standard CRUD operations
Route::get('/photographers', [UserController::class, 'getPhotographers']); // Get all photographers (users with role_id = 2)

Route::middleware('auth:sanctum')->post('/productos', [ProductController::class, 'store']);