<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id)->paginate(5); 
        return view('dashboard', compact('contacts'));
    }
}
