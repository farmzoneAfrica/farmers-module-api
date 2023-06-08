<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\Controller;
use App\Services\Auth\FarmerRegisterServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Seshac\Otp\Otp;

class ResendResetPinOtpController extends Controller
{
    /**
     * Regenerate OTP
     * @OA\Get (
     *     path="/api/auth/farmer/resend-forgot-pin-otp",
     *     tags={"Farmer Auth"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerForgotPinResendOtp",
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(),
     *          )
     *      )
     * )
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $resend = Otp::setKey('forgot-pin')->generate(auth()->user()->id);
        return ($resend->status)
            ? $this->sendResponse($resend->message)
            : $this->sendError($resend->message);
    }
}
