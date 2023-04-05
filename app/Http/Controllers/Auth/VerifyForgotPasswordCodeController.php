<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\VerifyForgotPasswordCodeRequest;
use Seshac\Otp\Otp;

class VerifyForgotPasswordCodeController extends BaseController
{
    public function __invoke(VerifyForgotPasswordCodeRequest $request)
    {
        $validate = Otp::setKey('forgot-password')->validate(auth()->user()->id, $request->otp);
        return $validate->status
            ? $this->sendResponse('OTP validated')
            : $this->sendError($validate->message);
    }
}
