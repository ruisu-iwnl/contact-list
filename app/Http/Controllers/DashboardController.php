<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch contacts related to the logged-in user
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id)->get();

        return view('dashboard', compact('contacts'));
    }

    public function createContact()
    {
        return view('contacts.create');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|max:255',
            'notes' => 'nullable',
            'avatar' => 'nullable|file',
        ]);

        // Ensure the created contact is associated with the logged-in user
        $request->merge(['user_id' => Auth::id()]);
        $contact = Contact::create($request->all());

        return redirect()->route('contacts.show', $contact->id)
            ->with('success', 'Contact created successfully.');
    }

    public function editContact(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function updateContact(Request $request, Contact $contact)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|max:255',
            'notes' => 'nullable',
            'avatar' => 'nullable|file',
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.show', $contact->id)
            ->with('success', 'Contact updated successfully.');
    }

    public function destroyContact(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Contact deleted successfully.');
    }

    public function createContactNumber()
    {
        return view('contact_numbers.create');
    }

    public function storeContactNumber(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'number' => 'required|string|max:15',
        ]);

        // Ensure the created contact number is associated with a valid contact ID
        $contactNumber = ContactNumber::create($request->all());

        return redirect()->route('contact_numbers.show', $contactNumber->id)
            ->with('success', 'Contact number created successfully.');
    }

    public function editContactNumber(ContactNumber $contactNumber)
    {
        return view('contact_numbers.edit', compact('contactNumber'));
    }

    public function updateContactNumber(Request $request, ContactNumber $contactNumber)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'number' => 'required|string|max:15',
        ]);

        $contactNumber->update($request->all());

        return redirect()->route('contact_numbers.show', $contactNumber->id)
            ->with('success', 'Contact number updated successfully.');
    }

    public function destroyContactNumber(ContactNumber $contactNumber)
    {
        $contactNumber->delete();

        return redirect()->route('contact_numbers.index')
            ->with('success', 'Contact number deleted successfully.');
    }
}
