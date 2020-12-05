<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('companies')->group(function () {
        Route::get('', [CompanyController::class, 'list'])->name('companies.list');
        Route::post('', [CompanyController::class, 'create'])->name('companies.create');
        Route::get('{company:id}', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('{company:id}/invoices', [CompanyController::class, 'invoices'])->name('companies.invoices');
    });

    Route::prefix('invoices')->group(function () {
        Route::post('', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::get('{invoice:id}', [InvoiceController::class, 'show'])->name('invoices.show');
    });
});
