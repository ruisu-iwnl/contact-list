<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PreventAccessWhenAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Check if the user is trying to access /login or /register
            if ($request->is('login') || $request->is('register')) {
                // Check if the user's session exists in Redis
                if (Redis::exists('user:' . Auth::id())) {
                    return redirect()->route('dashboard'); // Redirect to dashboard if session exists
                }
            }
        }

        return $next($request);
    }
}
