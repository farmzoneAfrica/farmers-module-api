<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\ChangePhoneNumberRequest;
use App\Http\Requests\Auth\Farmer\RegisterVerifyOTPRequest;
use App\Http\Requests\Auth\Farmer\StoreKycRequest;
use App\Http\Requests\Auth\Farmer\RegisterRequest;
use App\Http\Requests\EnrollFaceIdRequest;
use App\Http\Requests\SetPinRequest;
use App\Services\Auth\FarmerRegisterServices;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    /**
     * Farmer Registration
     * @OA\Post (
     *     path="/api/auth/farmer/register",
     *     tags={"Farmer Onboarding"},
     *     operationId="farmerRegistration",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="state_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="local_government_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="ward_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="accept_terms",
     *                     type="boolean"
     *                 ),
     *
     *                 example={"first_name": "Samuel", "last_name": "Sammy", "phone": "08012345678","state_id": 1, "local_government_id": 1,"ward_id": 1, "accept_terms": 1}
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
     * @param RegisterRequest $request
     * @param FarmerRegisterServices $services
     * @return JsonResponse
     */
    public function index(RegisterRequest $request, FarmerRegisterServices $services): JsonResponse
    {
        return $services->register($request);
    }

    /**
     * Verify Registration OTP
     * @OA\Post (
     *     path="/api/auth/farmer/verify-otp",
     *     tags={"Farmer Onboarding"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerVerifyRegisterOtp",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="otp",
     *                     type="string"
     *                 ),     *
     *                 example={"otp": "123456"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(),
     *          )
     *      )
     * )
     * @param RegisterVerifyOTPRequest $request
     * @param FarmerRegisterServices $services
     * @return JsonResponse
     */

    public function verifyOTP(RegisterVerifyOTPRequest $request, FarmerRegisterServices $services): JsonResponse
    {
        return $services->verifyOTP($request);
    }

    /**
     * Regenerate OTP
     * @OA\Get (
     *     path="/api/auth/farmer/resend-otp",
     *     tags={"Farmer Onboarding"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerRegistrationResendOtp",
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(),
     *          )
     *      )
     * )
     * @param FarmerRegisterServices $services
     * @return JsonResponse
     */

    public function resendOTP(FarmerRegisterServices $services): JsonResponse
    {
        return $services->resendOTP();
    }

    /**
     * Change Phone Number
     * @OA\Post (
     *     path="/api/auth/farmer/change-phone",
     *     tags={"Farmer Onboarding"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerRegistrationChangePhoneNumber",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),     *
     *                 example={"phone": "08123456789"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(),
     *          )
     *      )
     * )
     * @param ChangePhoneNumberRequest $request
     * @param FarmerRegisterServices $services
     * @return JsonResponse
     */
    public function changePhoneNumber(ChangePhoneNumberRequest $request, FarmerRegisterServices $services): JsonResponse
    {
        return $services->changePhoneNumber($request);
    }

    public function enrollFaceId(EnrollFaceIdRequest $request, FarmerRegisterServices $services): JsonResponse
    {
        return $services->enrollFaceId($request);
    }

    public function kyc(StoreKycRequest $request, FarmerRegisterServices $services): JsonResponse
    {
        return $services->updateKyc($request);
    }

    /**
     * Set Farmer PIN
     * @OA\Post (
     *     path="/api/auth/farmer/set-pin",
     *     tags={"Farmer Onboarding"},
     *     security={{"sanctum":{}}},
     *     operationId="farmerSetPin",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="pin",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="confirm_pin",
     *                     type="string"
     *                 ),
     *                 example={"pin": "4125", "confirm_pin":"4125"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful created", @OA\JsonContent()),
     *      @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(),
     *          )
     *      )
     * )
     * @param RegisterVerifyOTPRequest $request
     * @param FarmerRegisterServices $services
     * @return JsonResponse
     */
    public function setPin(SetPinRequest $request, FarmerRegisterServices $services)
    {
        return $services->setPin($request);
    }
}
