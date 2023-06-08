<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Services\Auth\FarmerRegisterServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{
    /**
     * Farmer Logout
     * @OA\Get (
     *     path="/api/auth/farmer/logout",
     *     tags={"Farmer Auth"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerLogout",
     *     @OA\Response(response=200, description="Successful created", @OA\JsonContent()),
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
    public function __invoke()
    {
        auth()->user()->tokens()->delete();
        return $this->sendResponse('User logged out');
    }
}
