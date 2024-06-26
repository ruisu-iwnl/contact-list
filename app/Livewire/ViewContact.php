<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;

class ViewContact extends Component
{
    public $contact;

    public function mount(Contact $contact)
    {
        // Load the contact details along with related numbers
        $this->contact = $contact->load('numbers');
    }
    
    public function render()
    {
        return view('livewire.view-contact', [
            'contact' => $this->contact,
        ]);
    }
}
