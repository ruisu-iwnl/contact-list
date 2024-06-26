<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;

class ViewContact extends Component
{
    public $contact;
    public $editingField = null;
    public $editValue;

    protected $rules = [
        'editValue' => 'required',
    ];

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

    public function editField($field)
    {
        $this->editingField = $field;
        $this->editValue = $this->contact->{$field};
    }

    public function saveEdit()
    {
        $this->validate();

        $this->contact->{$this->editingField} = $this->editValue;
        $this->contact->save();

        $this->editingField = null;
    }
}
