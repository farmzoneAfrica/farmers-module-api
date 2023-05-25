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
     *                     property="login",
     *                     type="string"
     *                 ),
     *                 example={"login": "08012345678"}
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
        $user = User::where('phone', $request->login)->orWhere('email', $request->login)->first();
        if (!$user) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse('User found', '', $user->createToken('login-pin')->plainTextToken);
    }
}
