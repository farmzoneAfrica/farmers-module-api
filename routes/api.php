<?php

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

Route::get('states', [\App\Http\Controllers\StateController::class, 'index']);
Route::get('local-governments/{state_id}', [\App\Http\Controllers\StateController::class, 'lgas']);
Route::get('wards/{local_government_id}', [\App\Http\Controllers\StateController::class, 'wards']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user',  [\App\Http\Controllers\Farmers\UserController::class, 'index']);
});
