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
    
    Route::middleware('auth:api')->group(function () {
        Route::get('get-voucher', [VoucherController::class, 'getVoucher'])->name('get-voucher');
        Route::get('voucher/{id}/detail', [VoucherController::class, 'detailVoucher'])->name('detail-voucher');
    });