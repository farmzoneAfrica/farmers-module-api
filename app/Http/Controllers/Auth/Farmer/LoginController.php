<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\LoginRequest;
use App\Models\User;
use App\Services\ApexaService;
use Seshac\Otp\Otp;

class LoginController extends BaseController
{
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
