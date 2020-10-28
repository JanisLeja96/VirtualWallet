<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/wallets', [WalletController::class, 'index'])
    ->name('wallets');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/wallets/create', [WalletController::class, 'create'])
    ->name('createWallet');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/wallets/store', [WalletController::class, 'store'])
    ->name('storeWallet');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/wallets/{wallet}', [WalletController::class, 'show'])
    ->name('showWallet');

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/wallets/{wallet}', [WalletController::class, 'destroy'])
    ->name('deleteWallet');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/wallets/{wallet}/edit', [WalletController::class, 'edit'])
    ->name('editWallet');

Route::middleware(['auth:sanctum', 'verified'])
    ->put('/wallets/{wallet}', [WalletController::class, 'update'])
    ->name('updateWallet');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/wallets/{wallet}/send', [TransactionController::class, 'create'])
    ->name('createTransaction');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/wallets/{wallet}/send', [TransactionController::class, 'store'])
    ->name('sendMoney');

Route::middleware(['auth:sanctum', 'verified'])
    ->delete('/wallets/{wallet}/transactions/{transaction}', [TransactionController::class, 'hide'])
    ->name('hideTransaction');
