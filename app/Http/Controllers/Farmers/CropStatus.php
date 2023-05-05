<?php

namespace App\Http\Controllers\Farmers;

use App\Http\Controllers\Controller;
use App\Services\Farmers\CropsService;
use Illuminate\Http\Request;

class CropStatus extends Controller
{
    /**
     * Get List of Crops Statuses
     * @OA\Get (
     *     path="/api/farmer/crop-statuses",
     *     tags={"Farmers' Module"},
     *     security={{"sanctum":{}}},
     *     operationId="cropsStatusesList",
     *     @OA\Parameter(
     *         name="sort_field",
     *         in="query",
     *         description="A list of things.",
     *         required=false,
     *         example="id"
     *     ),
     *     @OA\Parameter(
     *         name="sort_type (asc or desc)",
     *         in="query",
     *         description="A list of things.",
     *         required=false,
     *         example="asc"
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="number of states to return per page (-1 for all)",
     *         required=false,
     *         example="-1"
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term (status name)",
     *         required=false,
     *         example="irrigation"
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
        return $service->cropStatuses($request);
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
