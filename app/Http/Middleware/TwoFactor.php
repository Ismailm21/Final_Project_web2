<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->otp_code && !$request->is('verify') && !$request->is('logout')) {
            return redirect()->route('verify.otp');
        }

        return $next($request);
    }
}
