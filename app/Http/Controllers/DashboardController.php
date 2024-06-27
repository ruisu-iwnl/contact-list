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
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id)->get();
        return view('dashboard', compact('contacts'));
    }

}
