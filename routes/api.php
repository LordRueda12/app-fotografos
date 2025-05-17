<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImagenController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('imagenes', ImagenController::class);
Route::apiResource('categorias', \App\Http\Controllers\Api\CategoriaImagenController::class);

Route::get('imagenes/usuario/{userId}', [ImagenController::class, 'getImagesByUser']);

// User API Routes
Route::apiResource('users', UserController::class)->except(['create', 'edit']); // Use apiResource for standard CRUD operations
Route::get('/photographers', [UserController::class, 'getPhotographers']); // Get all photographers (users with role_id = 2)