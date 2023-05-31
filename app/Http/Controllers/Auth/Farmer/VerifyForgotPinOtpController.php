<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Farmer\LoginRequest;
use App\Http\Requests\VerifyForgotPinOtpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Seshac\Otp\Otp;

class VerifyForgotPinOtpController extends Controller
{
    /**
     * Farmer Forgot PIN
     * @OA\Post (
     *     path="/api/auth/farmer/verify-forgot-pin-otp",
     *     operationId="farmerVerifyForgotPinOtp",
     *     tags={"Farmer Auth"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="otp",
     *                     type="string"
     *                 ),
     *                 example={"otp": "1237"}
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
     * @param VerifyForgotPinOtpRequest $request
     * @return JsonResponse
     */
    public function __invoke(VerifyForgotPinOtpRequest $request)
    {
        $validate = Otp::setKey('forgot-pin')->validate(auth()->user()->id, $request->otp);
        return $validate->status
            ? $this->sendResponse('OTP validated')
            : $this->sendError($validate->message);
    }
}
