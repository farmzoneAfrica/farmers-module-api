<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ForgotPasswordPostRequest;
use App\Models\User;
use App\Services\ApexaService;
use Seshac\Otp\Otp;

class ForgotPasswordController extends BaseController
{
    public function __invoke(ForgotPasswordPostRequest $request) {
        $user = User::where('phone', $request->phone)->first();
        if (!$user) return $this->sendError('Phone number not found');
        $otp = Otp::setValidity(30)
            ->setKey('forgot-password')
            ->setLength(6)
            ->setMaximumOtpsAllowed(10)
            ->setOnlyDigits(true)
            ->setUseSameToken(false)
            ->generate($user->id);

        if (!$otp->status) return $this->sendError($otp->message);

        if (env('OTP_GATEWAY') == 'apexa') {
            $apexa = new ApexaService($otp->token, $request->phone);
            $apexa->send();
        }

        return $this->sendResponse('', 'OTP Sent', $user->createToken('forgot-password')->plainTextToken);
    }
}
