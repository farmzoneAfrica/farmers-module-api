<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Seshac\Otp\Otp;

class VerifyLoginCodeController extends BaseController
{
    public function __invoke(Request $request)
    {
        $validate = Otp::setKey('login')->validate(auth()->user()->id, $request->otp);
        if (!$validate->status) return $this->sendError($validate->message);
        auth()->user()->currentAccessToken()->delete();
        return $this->sendResponse('OTP validated', '', auth()->user()->createToken('auth')->plainTextToken);
    }
}
