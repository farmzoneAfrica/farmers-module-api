<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FarmerRegisterRequest;
use App\Http\Requests\FarmerStoreKycRequest;
use App\Models\User;
use App\Services\Auth\FarmerRegisterServices;
use Illuminate\Http\JsonResponse;

class FarmerRegisterController extends BaseController
{
    /**
     * Handle the incoming request.
     * @param FarmerRegisterRequest $request
     * @param FarmerRegisterServices $farmerRegisterServices
     * @return JsonResponse
     */
    public function index(FarmerRegisterRequest $request, FarmerRegisterServices $farmerRegisterServices): JsonResponse
    {
        return $farmerRegisterServices->register($request);
    }

    public function verifyOTP()
    {

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
