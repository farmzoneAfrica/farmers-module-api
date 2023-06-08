<?php

namespace App\Http\Controllers\Farmers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(\Illuminate\Http\Client\Request $request)
    {
        return $request->user();
    }
}
