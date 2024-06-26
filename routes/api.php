<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




    Route::post('register-store',[UserController::class, 'registerStore'] )-> name('register-store');
    Route::post('login',[UserController::class, 'login'] )-> name('login');
    Route::post('logout',[UserController::class, 'logout'] )-> name('logout');
    
    Route::middleware('auth:api')->group(function () {
        Route::get('get-voucher', [VoucherController::class, 'getVoucher'])->name('get-voucher');
        Route::get('get-voucher/{kategori}', [VoucherController::class, 'getVoucherKategori'])->name('get-voucher');
        Route::get('voucher/{id}/detail', [VoucherController::class, 'detailVoucher'])->name('detail-voucher');
        Route::post('voucher/{id}/claim', [VoucherController::class, 'claimVoucher'])->name('claim-voucher');
        Route::post('voucher/{id}/remove', [VoucherController::class, 'removeVoucher'])->name('remove-voucher');

        Route::get('history', [VoucherController::class, 'history'])->name('history');
        Route::get('history/{kategori}', [VoucherController::class, 'historyKategori'])->name('history-kategori');
        Route::get('kategori', [VoucherController::class, 'kategoryVoucher'])->name('kategori-voucher');
        Route::get('kategori-claim', [VoucherController::class, 'kategoryVoucherClaim'])->name('kategori-voucher-claim');
    }); 