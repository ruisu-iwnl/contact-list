<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ViewContact extends Component
{
    public $contact;
    public $avatarUrl;

    public function mount(Contact $contact)
    {
        // Load the contact details along with related numbers
        $this->contact = $contact->load('numbers');
    
        // Retrieve the avatar data from Redis using the stored Redis key
        if ($this->contact->avatar) {
            $avatarData = Redis::get($this->contact->avatar);

            // Ensure avatar data is not null
            if ($avatarData !== null) {
                // Generate a unique filename for the temporary image
                $tempFileName = 'temp_avatar_' . Str::random(10) . '.jpg';
                
                // Ensure the directory exists or create it
                $tempImagePath = storage_path('app/public/temp/');
                if (!file_exists($tempImagePath)) {
                    mkdir($tempImagePath, 0755, true);
                }

                // Store the avatar data as a temporary image file
                $tempImagePath = $tempImagePath . $tempFileName;
                file_put_contents($tempImagePath, $avatarData);
                
                // Set the avatar URL to the temporary image path
                $this->avatarUrl = asset('storage/temp/' . $tempFileName);
            }
        } else {
            $this->avatarUrl = null;
        }
    }
    
    public function render()
    {
        return view('livewire.view-contact', [
            'contact' => $this->contact,
            'avatarUrl' => $this->avatarUrl,
        ]);
    }
}
