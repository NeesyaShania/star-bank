<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminCustomerController;

// Authentication Route
Route::post('/auth/login', [AuthController::class, 'login']);

// Admin Routes - Manajemen Customer
Route::get('/admin/customers', [AdminCustomerController::class, 'index']);
Route::post('/admin/customers', [AdminCustomerController::class, 'store']);
Route::put('/admin/customers/{id}', [AdminCustomerController::class, 'update']);
Route::delete('/admin/customers/{id}', [AdminCustomerController::class, 'destroy']);

use App\Http\Controllers\AdminAccountController;

// Admin Routes - Manajemen Rekening (Account)
Route::get('/admin/accounts', [AdminAccountController::class, 'index']);
Route::post('/admin/accounts', [AdminAccountController::class, 'store']);
Route::put('/admin/accounts/{id}', [AdminAccountController::class, 'update']);
Route::delete('/admin/accounts/{id}', [AdminAccountController::class, 'destroy']);

use App\Http\Controllers\AdminDepositoTypeController;

// Admin Routes - Manajemen Tipe Deposito
Route::get('/admin/deposito-types', [AdminDepositoTypeController::class, 'index']);
Route::post('/admin/deposito-types', [AdminDepositoTypeController::class, 'store']);
Route::put('/admin/deposito-types/{id}', [AdminDepositoTypeController::class, 'update']);
Route::delete('/admin/deposito-types/{id}', [AdminDepositoTypeController::class, 'destroy']);

use App\Http\Controllers\CustomerTransactionController;

// Customer Routes - Transaksi
Route::post('/customer/deposit', [CustomerTransactionController::class, 'deposit']);
Route::post('/customer/withdraw', [CustomerTransactionController::class, 'withdraw']);
Route::get('/customer/dashboard/{id}', [CustomerTransactionController::class, 'getDashboardData']);