<?php


namespace App\Services\Auth;


use App\Events\FarmerRegistered;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FarmerRegisterRequest;
use App\Http\Requests\FarmerRegisterVerifyOTPRequest;
use App\Models\User;
use Seshac\Otp\Otp;

class FarmerRegisterServices extends BaseController
{
    /**
     * @param FarmerRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(FarmerRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::updateOrCreate(
            ['phone' => $request->phone],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'state_id' => $request->state_id,
                'local_government_id' => $request->local_government_id,
                'ward_id' => $request->ward_id,
                'user_type_id'=>1
            ]
        );

        FarmerRegistered::dispatch($user);
        return $this->sendResponse($user, 'Registration successfully')->withCookie('x-onboarding-token', $user->createToken('x-onboarding-token')->plainTextToken);
    }

    public function verifyOTP(FarmerRegisterVerifyOTPRequest $request)
    {
        $user = auth()->user();
        $verify = Otp::setKey('farmer-reg')->validate($user->id, $request->otp);
        return ($verify->status) ? $this->sendResponse($verify->message) : $this->sendError($verify->message);
    }
}
