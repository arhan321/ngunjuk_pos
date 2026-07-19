<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/home', [ProductController::class, 'index'])->name('frontend.home');
    Route::get('/history', [HistoryController::class, 'index'])->name('frontend.history');
    Route::get('/settings', [FrontendController::class, 'settings'])->name('frontend.settings');
    Route::put('/settings/password', [FrontendController::class, 'updatePassword'])
        ->name('frontend.password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/api/products', [ProductController::class, 'list'])->name('api.products.list');
    Route::post('/api/orders', [OrderController::class, 'store'])->name('api.orders.store');
    Route::get('/api/history', [HistoryController::class, 'list'])->name('api.history.list');
});