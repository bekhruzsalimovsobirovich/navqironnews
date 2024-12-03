<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categories\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'role:administrator']], function ($query) {
    Route::apiResource('categories', CategoryController::class);
});


// -------------------------------------------------------- GLOBAL --------------------------------------------------------
Route::group(['prefix' => '{locale}', 'middleware' => 'localization'], function () {
    Route::get('categories', [CategoryController::class, 'getAll']);
});
