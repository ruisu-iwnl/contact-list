<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

class ViewContact extends Component
{
    use WithFileUploads;

    public $contact;
    public $editingField = null;
    public $editValue;
    public $image;
    public $isEditingAvatar = false;

    protected $rules = [
        'editValue' => 'required',
        'image' => 'nullable|image|max:1024', // Adjust max file size as needed
    ];

    public function mount(Contact $contact)
    {
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

    public function startEditingAvatar()
    {
        $this->isEditingAvatar = true;
    }

    public function cancelEditingAvatar()
    {
        $this->isEditingAvatar = false;
        $this->reset(['image']);
    }

    public function saveEdit()
    {
        $this->validate();

        // Handle image upload
        if ($this->image) {
            // Delete previous avatar if exists
            if ($this->contact->avatar) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $this->contact->avatar));
            }

            // Store new avatar
            $fileName = time() . '_' . $this->image->getClientOriginalName();
            $path = $this->image->storeAs('avatars', $fileName, 'public');
            $this->contact->avatar = '/storage/' . $path;
        }

        if ($this->editingField) {
            $this->contact->{$this->editingField} = $this->editValue;
        }
        
        $this->contact->save();

        $this->editingField = null;
        $this->isEditingAvatar = false;
        $this->reset(['image']);

        // return redirect('/dashboard');
    }
}
