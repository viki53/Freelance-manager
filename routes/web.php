<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
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

    Route::prefix('companies')->group(function () {
        Route::get('', [CompanyController::class, 'list'])->name('companies.list');
        Route::post('', [CompanyController::class, 'create'])->name('companies.create');

        Route::prefix('{company:id}')->group(function () {
            Route::get('', [CompanyController::class, 'show'])->name('companies.show');

            Route::prefix('invoices')->group(function () {
                Route::get('', [CompanyController::class, 'invoices'])->name('companies.invoices.list');
                Route::post('', [CompanyController::class, 'createInvoice'])->name('companies.invoices.create');
                Route::prefix('{invoice:id}')->group(function () {
                    Route::get('', [CompanyController::class, 'showInvoice'])->name('companies.invoices.show');
                });
            });
        });
    });

    Route::prefix('invoices')->group(function () {
        Route::get('', [InvoiceController::class, 'list'])->name('invoices.list');
        Route::post('', [InvoiceController::class, 'create'])->name('invoices.create');

        Route::prefix('{invoice:id}')->group(function () {
            Route::get('', [InvoiceController::class, 'show'])->name('invoices.show');
            Route::post('items', [InvoiceController::class, 'addItem'])->name('invoices.items.add');
        });
    });
});
