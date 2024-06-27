<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Log;

class ActivityLog extends Component
{
    use WithPagination;

    public function render()
    {
        $logs = Log::with('user')->orderByDesc('created_at')->paginate(5);

        return view('livewire.activity-log', [
            'logs' => $logs,
        ]);
    }
}
