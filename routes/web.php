<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(function () {
    Route::get('/ajustes', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{any?}', function () {
    if (Auth::check()) {
        switch(Auth::user()->role_id) {
            case 1:
                return view('dashboardAdmin');
            case 2:
                return view('dashboardPhotographer');
            case 3:
                return view('dashboardClient');
            }
    } else {
        return view('welcome');
    }
})->name('home');


require __DIR__.'/auth.php';
