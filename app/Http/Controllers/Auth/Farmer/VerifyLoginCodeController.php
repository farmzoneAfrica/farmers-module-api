<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Seshac\Otp\Otp;

class VerifyLoginCodeController extends BaseController
{
    /**
     * Verify Farmer Login OTP
     * @OA\Post (
     *     path="/api/auth/farmer/verify-login-code",
     *     tags={"Farmer Auth"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerVerifyLoginOtp",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="otp",
     *                     type="string"
     *                 ),
     *                 example={"otp": "407353"}
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
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $validate = Otp::setKey('login')->validate(auth()->user()->id, $request->otp);
        if (!$validate->status) return $this->sendError($validate->message);
        auth()->user()->currentAccessToken()->delete();
        return $this->sendResponse('OTP validated', '', auth()->user()->createToken('farmer-auth')->plainTextToken);
    }
}
