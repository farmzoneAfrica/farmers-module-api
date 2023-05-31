<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPinRequest;
use App\Http\Requests\VerifyForgotPinOtpRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPinController extends Controller
{

    /**
     * Farmer Forgot PIN
     * @OA\Post (
     *     path="/api/auth/farmer/reset-pin",
     *     operationId="farmerResetPin",
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
     *                  @OA\Property(
     *                     property="confirm_pin",
     *                     type="string"
     *                 ),
     *                 example={"pin": "1237", "confirm_pin": "1237"}
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
     * @param ResetPinRequest $request
     * @return JsonResponse
     */
    public function __invoke(ResetPinRequest $request)
    {
        $user = User::find(auth()->user()->id);
        //$user->pin = bcrypt($request->pin);
        $user->pin = $request->pin;
        $user->save();
        $user->tokens()->delete();
        return $this->sendResponse('Pin changed successfully');
    }
}
