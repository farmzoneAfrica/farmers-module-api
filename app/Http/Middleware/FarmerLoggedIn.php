<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FarmerLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check())  {
            $token_name = request()->user()->currentAccessToken()->name;
            return $token_name == 'farmer-auth' ? $next($request) : response()->json(['message'=>'Unauthenticated.']);
        }

        return $next($request);
    }
}
