<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('/products', ProductsController::class);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
