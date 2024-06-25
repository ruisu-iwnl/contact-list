<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();

                $user = Auth::user();
                Cache::put("user:{$user->id}", $user, now()->addMinutes(30));

                // Storing session data in Redis
                Cache::put("session:{$request->session()->getId()}", [
                    'username' => $request->username,
                    'password' => $request->password,
                ], now()->addMinutes(30));

                Log::info('Login successful for user: ' . $user->username);
                return redirect()->intended('/dashboard');
            }

            Log::warning('Login failed for user: ' . $request->username);
            return back()->withErrors([
                'login' => 'The provided credentials do not match our records.',
            ])->withInput();
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Login failed. Please try again later.']);
        }
    }
}
