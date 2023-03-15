<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FarmerRegisterRequest;
use App\Http\Requests\FarmerRegisterVerifyOTPRequest;
use App\Http\Requests\FarmerStoreKycRequest;
use App\Models\User;
use App\Services\Auth\FarmerRegisterServices;
use Illuminate\Http\JsonResponse;

class FarmerRegisterController extends BaseController
{
    public function index(FarmerRegisterRequest $request, FarmerRegisterServices $services): JsonResponse
    {
        return $services->register($request);
    }

    public function verifyOTP(FarmerRegisterVerifyOTPRequest $request, FarmerRegisterServices $services): JsonResponse
    {
        return $services->verifyOTP($request);
    }

    public function kyc(FarmerStoreKycRequest $request, FarmerRegisterServices $farmerRegisterServices): JsonResponse
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'state_id' => $request->state_id,
            'local_government_id' => $request->local_government_id,
            'ward_id' => $request->ward_id,
            'user_type_id'=>1
        ]);

        return $this->sendResponse($user, 'Registration successfully');
    }

}
