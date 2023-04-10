<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Seshac\Otp\Models\Otp;

class ResetPasswordController extends BaseController
{
    public function __invoke(ResetPasswordRequest $request)
    {
        //check last otp if verified within 5 mins
        $user = User::find(auth()->user()->id);
        $user->password = \Hash::make($request->password);
        $user->save();
        auth()->user()->currentAccessToken()->delete();
        return $this->sendResponse('Password changed successfully');
    }
}
