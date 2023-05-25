<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\LoginRequest;
use App\Http\Requests\FaceIdLoginRequest;
use App\Models\FaceBiometric;
use Illuminate\Http\JsonResponse;

class FaceLoginController extends BaseController
{
    public function __invoke(FaceIdLoginRequest $request)
    {
        $check = FaceBiometric::where([
            'user_code' => $request->code,
            'facial_id'=>$request->facial_id])->first();
    }
}
