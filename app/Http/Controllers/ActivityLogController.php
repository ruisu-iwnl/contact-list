<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = Log::with('user')->orderByDesc('created_at')->paginate(5);
        
        return view('livewire.activity-log', compact('logs')); 
    }
}
