<?php

namespace App\Http\Controllers;

use App\Models\LocalGovernment;
use App\Models\State;
use App\Services\StateService;
use Illuminate\Http\Request;

class StateController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param StateService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, StateService $service): \Illuminate\Http\JsonResponse
    {
        return $service->states($request);
    }


    /**
     * @param Request $request
     * @param StateService $service
     * @param string $state_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function lgas(Request $request, StateService $service, string $state_id): \Illuminate\Http\JsonResponse
    {
        return $service->lgas($request, $state_id);
    }

    /**
     * @param Request $request
     * @param StateService $service
     * @param string $lga_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function wards(Request $request, StateService $service, string $lga_id): \Illuminate\Http\JsonResponse
    {
        return $service->wards($request, $lga_id);
    }
}
