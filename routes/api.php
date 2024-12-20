<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Files\FileController;
use App\Http\Controllers\Informations\InformationController;
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
Route::post('/credential/update/{user}', [AuthController::class, 'updateCredentials']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'role:administrator']], function ($query) {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('informations', InformationController::class);
    Route::post('information/{information}/update', [InformationController::class,'update']);
    Route::post('category/{category}/update', [CategoryController::class,'update']);
    Route::post('create/tags/{information}/information', [InformationController::class,'createTags']);

    Route::post('/upload/files', [FileController::class, 'storeImages']);
    Route::post('/delete/files', [FileController::class, 'deleteImages']);
    Route::post('/update/files', [FileController::class, 'updateImages']);
});


// -------------------------------------------------------- GLOBAL --------------------------------------------------------
Route::group(['prefix' => '{locale}', 'middleware' => 'localization'], function () {
    Route::get('categories', [CategoryController::class, 'getAll']);
    Route::get('news', [InformationController::class, 'paginate']);
    Route::get('latest/information', [InformationController::class, 'getThreeLatestInformation']);
    Route::get('latest', [InformationController::class, 'getTenLatestInformation']);
    Route::get('latest/more/read', [InformationController::class, 'getMoreReadInformation']);
    Route::get('latest/category/carousel', [InformationController::class, 'getEightGroupByCategoryInformation']);
    Route::get('show/{information}/information', [InformationController::class, 'showInformation']);
    Route::get('other/information', [InformationController::class, 'getOtherInformations']);
    Route::get('category/{category_id}/information', [InformationController::class, 'getCategoryInformation']);
});
Route::get('information/{information}/count', [InformationController::class,'updateViewCount']);
