<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnboardingAccess
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next (\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle($request, Closure $next): Response
    {
        if (Auth::check())  {
            $token_name = request()->user()->currentAccessToken()->name;
            return $token_name == 'x-onboarding-token' ? $next($request) : response()->json(['message'=>'Unauthenticated.']);
        }

        return $next($request);
    }
}
