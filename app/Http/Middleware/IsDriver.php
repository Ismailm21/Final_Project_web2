<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsDriver
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response

    {
        $user = auth('driver')->user();

        if (!$user) {
            return redirect()->route('driver.login')->withErrors(['access' => 'You must be a Driver']);
        }

        if ($user->role !== 'driver') {
            return redirect()->route('driver.login')->withErrors(['access' => 'Drivers only']);
        }

        return $next($request);
    }
}
