<?php

use Illuminate\Support\Facades\Route;

Route::get('crops', [\App\Http\Controllers\Farmers\CropsController::class, 'index']);
Route::get('crop-statuses', [\App\Http\Controllers\Farmers\CropStatus::class, 'index']);
Route::get('farm-size-units', [\App\Http\Controllers\Farmers\FarmSizeUnitController::class, 'index']);

