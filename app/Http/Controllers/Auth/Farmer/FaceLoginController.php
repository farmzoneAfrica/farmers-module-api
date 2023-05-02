<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\LoginRequest;
use App\Http\Requests\FaceIdLoginRequest;
use App\Models\FaceBiometric;
use Illuminate\Http\JsonResponse;

class FaceLoginController extends BaseController
{
    /**
     * Farmer Initiate Login
     * @OA\Post (
     *     path="/api/auth/farmer/login/face",
     *     operationId="farmerLogin",
     *     tags={"Farmer Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 example={"phone": "08012345678"}
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="false"),
     *          )
     *      )
     * )
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(FaceIdLoginRequest $request)
    {
        $check = FaceBiometric::where([
            'user_code' => $request->code, 'facial_id'=>$request->facial_id])->first();
    }
}
