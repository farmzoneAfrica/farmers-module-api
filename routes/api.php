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

Route::prefix('states')->group(function () {
    Route::get('/', [\App\Http\Controllers\StateController::class, 'index']);
    Route::get('{id}/lgas', [\App\Http\Controllers\StateController::class, 'lgas']);
    Route::get('{id}/wards', [\App\Http\Controllers\StateController::class, 'wards']);
});
