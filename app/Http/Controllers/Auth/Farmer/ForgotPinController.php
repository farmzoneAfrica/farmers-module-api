<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\ForgotPinRequest;
use App\Models\User;
use App\Services\ApexaService;
use Illuminate\Http\JsonResponse;
use Seshac\Otp\Otp;

class ForgotPinController extends BaseController
{
    /**
     * Farmer Forgot PIN
     * @OA\Post (
     *     path="/api/auth/farmer/forgot-pin",
     *     operationId="farmerForgotPin",
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
     * @param ForgotPinRequest $request
     * @return JsonResponse
     */
    public function __invoke(ForgotPinRequest $request) {
        $user = User::where('phone', $request->phone)->first();
        if (!$user) return $this->sendError('Phone number not found');
        $otp = Otp::setValidity(10000)
            ->setKey('forgot-pin')
            ->setLength(4)
            ->setMaximumOtpsAllowed(10)
            ->setOnlyDigits(true)
            ->setUseSameToken(false)
            ->generate($user->id);

        if (!$otp->status) return $this->sendError($otp->message);

        $user->tokens()->delete();
        if (env('OTP_GATEWAY') == 'apexa') {
            $apexa = new ApexaService($otp->token, $request->phone);
            $apexa->send();
        }

        return $this->sendResponse('', 'OTP Sent to Phone', $user->createToken('forgot-pin')->plainTextToken);
    }
}
