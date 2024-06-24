<?php

namespace App\Http\Controllers;

use App\Models\ContactNumber;
use Illuminate\Http\Request;

class ContactNumberController extends Controller
{
    /**
     * Display a listing of the contact numbers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactNumbers = ContactNumber::all();
        return view('contact_numbers.index', compact('contactNumbers'));
    }

    /**
     * Show the form for creating a new contact number.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact_numbers.create');
    }

    /**
     * Store a newly created contact number in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'number' => 'required|string|max:15',
        ]);

        $contactNumber = ContactNumber::create($request->all());

        return redirect()->route('contact_numbers.show', $contactNumber->id)
            ->with('success', 'Contact number created successfully.');
    }

    /**
     * Display the specified contact number.
     *
     * @param  \App\Models\ContactNumber  $contactNumber
     * @return \Illuminate\Http\Response
     */
    public function show(ContactNumber $contactNumber)
    {
        return view('contact_numbers.show', compact('contactNumber'));
    }

    /**
     * Show the form for editing the specified contact number.
     *
     * @param  \App\Models\ContactNumber  $contactNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactNumber $contactNumber)
    {
        return view('contact_numbers.edit', compact('contactNumber'));
    }

    /**
     * Update the specified contact number in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactNumber  $contactNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactNumber $contactNumber)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'number' => 'required|string|max:15',
        ]);

        $contactNumber->update($request->all());

        return redirect()->route('contact_numbers.show', $contactNumber->id)
            ->with('success', 'Contact number updated successfully.');
    }

    /**
     * Remove the specified contact number from storage.
     *
     * @param  \App\Models\ContactNumber  $contactNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactNumber $contactNumber)
    {
        $contactNumber->delete();

        return redirect()->route('contact_numbers.index')
            ->with('success', 'Contact number deleted successfully.');
    }
}
