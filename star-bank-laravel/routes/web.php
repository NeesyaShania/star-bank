<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\AdminDepositoTypeController;
use App\Http\Controllers\CustomerTransactionController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    //Customer
    Route::get('/customer', [AdminCustomerController::class, 'customerIndex']);
    Route::get('/customer/create', [AdminCustomerController::class, 'create']);
    Route::post('/customer/store', [AdminCustomerController::class, 'store']);
    Route::get('/customer/edit/{id}', [AdminCustomerController::class, 'edit']);
    Route::put('/customer/update/{id}', [AdminCustomerController::class, 'update']);
    Route::delete('/customer/delete/{id}', [AdminCustomerController::class, 'destroy']);

    // Account
    Route::get('/account', [AdminAccountController::class, 'accountIndex']);
    Route::get('/account/create', [AdminAccountController::class, 'create']);
    Route::post('/account/store', [AdminAccountController::class, 'store']);
    Route::get('/account/edit/{id}', [AdminAccountController::class, 'edit']);
    Route::put('/account/update/{id}', [AdminAccountController::class, 'update']);
    Route::delete('/account/delete/{id}', [AdminAccountController::class, 'destroy']);

    //Deposito Type
    Route::get('/deposit', [AdminDepositoTypeController::class, 'depositoIndex']);
    Route::get('/deposit/create', [AdminDepositoTypeController::class, 'create']);
    Route::post('/deposit/store', [AdminDepositoTypeController::class, 'store']);
    Route::get('/deposit/edit/{id}', [AdminDepositoTypeController::class, 'edit']);
    Route::put('/deposit/update/{id}', [AdminDepositoTypeController::class, 'update']);
    Route::delete('/deposit/delete/{id}', [AdminDepositoTypeController::class, 'destroy']);
});

Route::prefix('customer')->middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerTransactionController::class, 'index']);
    Route::get('/deposit', [CustomerTransactionController::class, 'showDeposit']);
    Route::post('/deposit', [CustomerTransactionController::class, 'deposit']);
    Route::get('/withdraw', [CustomerTransactionController::class, 'showWithdraw']);
    Route::post('/withdraw', [CustomerTransactionController::class, 'withdraw']);
});