<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('company')->group(function () {
        Route::get('', [CompanyController::class, 'show'])->name('company.show');
        Route::post('', [CompanyController::class, 'update'])->name('company.update');
    });

    Route::prefix('customers')->group(function () {
        Route::get('', [CustomerController::class, 'list'])->name('customers.list');
        Route::post('', [CustomerController::class, 'create'])->name('customers.create');

        Route::prefix('{customer:id}')->group(function () {
            Route::get('', [CustomerController::class, 'show'])->name('customers.show');
        });
    });

    Route::prefix('invoices')->group(function () {
        Route::get('', [InvoiceController::class, 'list'])->name('invoices.list');
        Route::post('', [InvoiceController::class, 'create'])->name('invoices.create');

        Route::prefix('{invoice:id}')->group(function () {
            Route::get('', [InvoiceController::class, 'show'])->name('invoices.show');
            Route::post('', [InvoiceController::class, 'update'])->name('invoices.update');
            Route::post('send', [InvoiceController::class, 'send'])->name('invoices.send');
            Route::post('items', [InvoiceController::class, 'addItem'])->name('invoices.items.add');
        });
    });
});
