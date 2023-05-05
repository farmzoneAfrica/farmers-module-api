<?php

namespace App\Http\Controllers\Farmers;

use App\Http\Controllers\Controller;
use App\Services\Farmers\FarmSizeUnitService;
use Illuminate\Http\Request;

class FarmSizeUnitController extends Controller
{
    /**
     * Get List of Farm Size Units
     * @OA\Get (
     *     path="/api/farm-size-units",
     *     tags={"Farmers' Module"},
     *     security={{"sanctum":{}}},
     *     operationId="farmSizeUnitsList",
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
     *         example="acres"
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
    public function index(Request $request, FarmSizeUnitService $service): \Illuminate\Http\JsonResponse
    {
        return $service->farmSizeUnitList($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
