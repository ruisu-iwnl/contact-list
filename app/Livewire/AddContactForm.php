<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\ContactNumber;
use App\Models\Log; // Import Log model
use Livewire\WithFileUploads;

class AddContactForm extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $numbers = [];
    public $address;
    public $notes;
    public $image;

    public function mount()
    {
        $this->numbers[] = '';
    }

    public function addNumber()
    {
        if (count($this->numbers) < 3) {
            $this->numbers[] = '';
        }
    }

    public function removeNumber($index)
    {
        unset($this->numbers[$index]);
        $this->numbers = array_values($this->numbers);
    }

    public function submit()
    {
        try {
            $validatedData = $this->validate([
                'name' => 'required|string|max:100',
                'email' => 'nullable|email|max:100',
                'numbers.*' => 'required|string|max:15',
                'address' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
                'image' => 'nullable|image|max:25000',
            ]);

            $user = Auth::user();

            $contact = new Contact();
            $contact->user_id = $user->id;
            $contact->name = $this->sanitizeField($this->name);
            $contact->email = $this->sanitizeField($this->email);
            $contact->address = $this->sanitizeField($this->address);
            $contact->notes = $this->sanitizeField($this->notes);

            if ($this->image) {
                $fileName = time() . '_' . $this->image->getClientOriginalName();
                $path = $this->image->storeAs('avatars', $fileName, 'public');
                $contact->avatar = '/storage/' . $path;
            }

            $contact->save();

            foreach ($this->numbers as $number) {
                if (!empty($number)) {
                    $contactNumber = new ContactNumber();
                    $contactNumber->contact_id = $contact->id;
                    $contactNumber->number = $this->sanitizeField($number);
                    $contactNumber->save();
                }
            }

            // Log activity
            Log::create([
                'user_id' => $user->id,
                'activity_description' => 'Added contact: ' . $contact->name,
                'old_values' => null,
                'new_values' => json_encode($contact->fresh()->toArray()), // Record new contact values
            ]);

            $this->reset(['name', 'email', 'numbers', 'address', 'notes', 'image']);

            session()->flash('message', 'Contact added successfully.');

            return redirect('/dashboard');
        } catch (\Exception $e) {
            session()->flash('error', 'Contact could not be added. Please try again later.');
            \Log::error('Error adding contact: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    private function sanitizeField($value)
    {
        return htmlspecialchars(trim($value));
    }

    public function render()
    {
        return view('livewire.add-contact-form');
    }
}
