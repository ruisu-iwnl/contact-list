<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Contact;
use App\Models\ContactNumber;
use App\Models\Log; // Include Log model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ViewContact extends Component
{
    use WithFileUploads;

    public $contact;
    public $editingField = null;
    public $editValue;
    public $editNumberValues = [];
    public $image;
    public $isEditingAvatar = false;

    protected $rules = [
        'editValue' => 'required',
        'editNumberValues.*.number' => 'required',
        'image' => 'nullable|image|max:1024',
    ];

    protected $listeners = ['toggleModal'];

    public function toggleModal($contactId)
    {
        $this->contact = Contact::with('numbers')->find($contactId);

        if (!$this->contact) {
            abort(404, 'Contact not found');
        }

        $this->editNumberValues = $this->contact->numbers->mapWithKeys(function ($number) {
            return [$number->id => ['number' => $number->number]];
        })->toArray();
        $this->resetErrorBag();
    }

    public function mount(Contact $contact)
    {
        $this->toggleModal($contact->id);
    }

    public function render()
    {
        if (!$this->contact) {
            return '';
        }

        return view('livewire.view-contact', [
            'contact' => $this->contact,
            'numbers' => $this->contact->numbers,
        ]);
    }

    public function editField($field)
    {
        $this->editingField = $field;
        if (Str::startsWith($field, 'numbers.')) {
            $id = substr($field, strpos($field, '.') + 1);
            $this->editValue = $this->editNumberValues[$id]['number'];
        } else {
            $this->editValue = $this->contact->{$field};
        }
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
    
        $oldValues = $this->contact->getOriginal();
    
        // Prepare variables to store updated field labels
        $updatedFields = [];
    
        if ($this->image) {
            if ($this->contact->avatar) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $this->contact->avatar));
            }
    
            $fileName = time() . '_' . $this->image->getClientOriginalName();
            $path = $this->image->storeAs('avatars', $fileName, 'public');
            $this->contact->avatar = '/storage/' . $path;
            $updatedFields[] = 'Avatar';
        }
    
        if ($this->editingField && !Str::startsWith($this->editingField, 'numbers.')) {
            $this->contact->{$this->editingField} = $this->editValue;
            $updatedFields[] = $this->getLabelForField($this->editingField);
        }
    
        foreach ($this->editNumberValues as $id => $numberData) {
            $currentNumber = htmlspecialchars($numberData['number'], ENT_QUOTES, 'UTF-8');
            $oldNumber = htmlspecialchars(ContactNumber::find($id)->number, ENT_QUOTES, 'UTF-8');
    
            if ($currentNumber !== $oldNumber) {
                ContactNumber::where('id', $id)->update(['number' => $currentNumber]);
                $updatedFields[] = 'Number';
            }
        }
    
        $this->contact->save();
    
        // Log activity with updated field labels
        Log::create([
            'user_id' => auth()->id(),
            'activity_description' => 'Updated contact (' . $this->contact->name . '): ' . implode(', ', $updatedFields),
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($this->contact->fresh()->toArray()),
        ]);
    
        $this->editingField = null;
        $this->isEditingAvatar = false;
        $this->reset(['image']);
    
        $this->toggleModal($this->contact->id);
    }
    


    public function deleteContact()
    {
        if ($this->contact) {
            // Log activity before deleting
            Log::create([
                'user_id' => auth()->id(),
                'activity_description' => 'Deleted contact: ' . $this->contact->name,
                'old_values' => json_encode($this->contact->toArray()),
            ]);

            $this->contact->delete();
        }

        $this->reset(['contact', 'editingField', 'editValue', 'editNumberValues', 'image', 'isEditingAvatar']);

        return redirect()->to('/dashboard');
    }

    // Helper function to get label for a specific field
    private function getLabelForField($field)
    {
        switch ($field) {
            case 'name':
                return 'Name';
            case 'email':
                return 'Email';
            case 'address':
                return 'Address';
            case 'notes':
                return 'Notes';
            // Add more cases as needed for other fields
            default:
                return ucfirst($field);
        }
    }


}
