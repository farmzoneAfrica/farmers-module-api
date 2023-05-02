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
     * Farmer Face ID Login
     * @OA\Post (
     *     path="/api/auth/farmer/login/face-id",
     *     operationId="farmerFaceIdLogin",
     *     tags={"Farmer Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user_code",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="facial_id",
     *                     type="string"
     *                 ),
     *                 example={"user_code": "6N9CzNQdtylNTxFKXf5mbWDHE61UTq", "facial_id":"facial_id from faceio"}
     *             )
     *         ),
         *
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
            'user_code' => $request->code,
            'facial_id'=>$request->facial_id])->first();
    }
}
