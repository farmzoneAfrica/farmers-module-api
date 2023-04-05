<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordAccess
{
    public function handle($request, Closure $next): Response
    {
        if (Auth::check())  {
            $token_name = request()->user()->currentAccessToken()->name;
            return $token_name == 'forgot-password' ? $next($request) : response()->json(['message'=>'Unauthenticated.']);
        }

        return $next($request);
    }
}
