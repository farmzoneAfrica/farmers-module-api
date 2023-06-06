<?php

namespace App\Http\Controllers\Auth\Farmer;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{

    public function __invoke(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->sendResponse('User logged out');
    }
}
