<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
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
    Route::post('login', App\Http\Controllers\Api\LoginController::class)->name('login');

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });