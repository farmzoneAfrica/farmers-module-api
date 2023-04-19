<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\LoginRequest;
use App\Http\Requests\Auth\Farmer\RegisterRequest;
use App\Models\User;
use App\Services\ApexaService;
use App\Services\Auth\FarmerRegisterServices;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\JsonResponse;
use Seshac\Otp\Otp;

class LoginController extends BaseController
{
    /**
     * Farmer Initiate Login
     * @OA\Post (
     *     path="/api/auth/farmer/login",
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
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return $this->sendError('Invalid Phone');
        }

        //send otp
        $otp = Otp::setKey('login')->generate($user->id);
        $apexa = new ApexaService($otp->token, $request->phone);
        $apexa->send();
        return $this->sendResponse('OTP Sent', '', $user->createToken('login-otp')->plainTextToken);
    }
}
