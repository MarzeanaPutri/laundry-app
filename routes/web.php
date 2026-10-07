<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/home', fn() => redirect()->route('welcome'));

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('outlets', OutletController::class);
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
        Route::get('/logs', [SystemLogController::class, 'index'])->name('logs.index');
    });

    // Admin & Kasir
    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('transactions', TransactionController::class)->except(['edit', 'update']);
        Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
    });

    // All roles (reports)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

require __DIR__ . '/auth.php';
