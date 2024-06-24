<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;

class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:useraccounts',
            'password' => 'required|string|min:6',
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        // Create user account
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        // Create contact associated with the user
        $contact = Contact::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('contacts.create')->with('success', 'Registration successful.');
    }
}
