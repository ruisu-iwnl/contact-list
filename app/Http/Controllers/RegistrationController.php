<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendRegistrationEmail;

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

        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            if (!$user) {
                throw new \Exception('Failed to create user.');
            }

            $contact = Contact::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            if (!$contact) {
                throw new \Exception('Failed to create contact.');
            }

            $contactNumber = ContactNumber::create([
                'contact_id' => $contact->id,
                'number' => $request->number,
            ]);

            if (!$contactNumber) {
                throw new \Exception('Failed to create contact number.');
            }

            if (empty($request->email)) {
                Log::info('User email: ' . $request->email); 
                throw new \Exception('User email is empty bro. Cannot send registration email.');
            }

            SendRegistrationEmail::dispatch($user, $request->email); 

            Cache::put("user_{$user->id}", $user, now()->addMinutes(30));
            Cache::put("contact_{$contact->id}", $contact, now()->addMinutes(30));
            Cache::put("contact_number_{$contactNumber->id}", $contactNumber, now()->addMinutes(30));

            Log::info('Received email: ' . $request->email);
            Log::info('Registration successful for user: ' . $user->username . ', email: ' . $request->email . ' and contact: ' . $contact->name);

            return redirect('/register')
                ->with('success', 'Registration successful.');

        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Registration failed. Please try again later.']);
        }
    }
}
