<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MuebleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('mueble', MuebleController::class)->only('store', 'update', 'destroy');
    Route::apiResource('category', CategoryController::class)->only('store', 'update', 'destroy');
    Route::get('logout', [AuthController::class], 'logout');
});


Route::apiResource('mueble', MuebleController::class)->only('index', 'show');
Route::apiResource('category', CategoryController::class)->only('index', 'show');
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);