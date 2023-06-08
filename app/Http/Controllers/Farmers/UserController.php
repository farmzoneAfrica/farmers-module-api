<?php

namespace App\Http\Controllers\Farmers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    /**
     * Regenerate OTP
     * @OA\Get (
     *     path="/api/farmer/user",
     *     tags={"Farmer Profile"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerProfile",
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
    public function index()
    {
        return $this->sendResponse(User::where('id', auth()->user()->id)->with('farms', 'wallet')->first());
    }
}
