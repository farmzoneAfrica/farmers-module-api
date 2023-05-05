<?php

namespace App\Http\Controllers\Farmers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Farmers\CreateFarmPostRequest;
use App\Services\Farmers\FarmServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FarmController extends Controller
{
    public function index(Request $request, FarmServices $farmServices)
    {
        return $farmServices->userFarmsList($request);
    }

    public function create()
    {

    }

    public function store(CreateFarmPostRequest $request, FarmServices $services): JsonResponse
    {
        return $services->createFarm($request);
    }
}
