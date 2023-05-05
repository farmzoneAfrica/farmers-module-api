<?php

namespace App\Http\Controllers\Farmers;

use App\Http\Controllers\Controller;
use App\Services\Farmers\CropsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FarmCropsController extends Controller
{
    public function index(Request $request, CropsService $service): JsonResponse
    {
        return $service->farmCropsList($request);
    }
}
