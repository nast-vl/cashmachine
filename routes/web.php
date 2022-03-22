<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;

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

Route::get('/', fn() => view('welcome'));

Route::get('/machine', fn() => view('machine'));
Route::get('/machine/success', fn() => view('stored'))->name('transaction.success');

Route::post('/machine/cash', [TransactionsController::class, 'storeCashTransaction'])->name('transactions.store.cash');
Route::post('/machine/creditCard', [TransactionsController::class, 'storeCreditCardTransaction'])->name('transactions.store.card');
Route::post('/machine/bankTransfer', [TransactionsController::class, 'storeBankTransferTransaction'])->name('transactions.store.transfer');
