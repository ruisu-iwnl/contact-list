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
        if (Auth::check()) {
            if ($request->is('login') || $request->is('register')) {
                if (Redis::exists('user:' . Auth::id())) {
                    return redirect()->route('dashboard'); 
                }
            }
        }

        return $next($request);
    }
}
