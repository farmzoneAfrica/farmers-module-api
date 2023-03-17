<?php

namespace App\Http\Controllers;

use App\Models\LocalGovernment;
use App\Models\State;
use App\Services\StateService;
use Illuminate\Http\Request;

class StateController extends BaseController
{

    /**
     * Get List of States
     * @OA\Get (
     *     path="/api/states",
     *     tags={"States"},
     *     @OA\Parameter(
     *         name="sort_field",
     *         in="query",
     *         description="A list of things.",
     *         required=false,
     *         example="id"
     *     ),
     *     @OA\Parameter(
     *         name="sort_type",
     *         in="query",
     *         description="A list of things.",
     *         required=false,
     *         example="asc"
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="number of states to return per page",
     *         required=false,
     *         example="-1"
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term (state name)",
     *         required=false,
     *         example="lagos"
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true)
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="false"),
     *          )
     *      )
     * )
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
