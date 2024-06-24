<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:useraccounts',
            'password' => 'required|confirmed',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:contacts|max:255',
            'address' => 'required|max:255',
            'number' => 'required|string|max:15',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $contact = Contact::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        $contactNumber = ContactNumber::create([
            'contact_id' => $contact->id,
            'number' => $request->number,
        ]);

        return redirect()->route('contacts.show', $contact->id)
            ->with('success', 'Registration successful.');
    }
}
