<?php

namespace App\Http\Controllers\Farmers;

use App\Http\Controllers\Controller;
use App\Services\CropsService;
use App\Services\StateService;
use Illuminate\Http\Request;

class CropsController extends Controller
{
    /**
     * Get List of Crops
     * @OA\Get (
     *     path="/api/crops",
     *     tags={"States"},
     *     operationId="cropsList",
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
     *         example="cassava"
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
    public function index(Request $request, CropsService $service): \Illuminate\Http\JsonResponse
    {
        return $service->cropsList($request);
    }
}
