<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImagenController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('imagenes', ImagenController::class);
Route::apiResource('categorias', \App\Http\Controllers\Api\CategoriaImagenController::class);