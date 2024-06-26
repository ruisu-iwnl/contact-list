<div>
    <form wire:submit.prevent="saveEdit" enctype="multipart/form-data">
        @csrf
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-md mx-auto">
            <header class="py-4 text-center">
                <h1 class="text-3xl font-bold">Contact Details</h1>
            </header>
            <div class="flex justify-center mb-6">
                <div class="relative">
                    @if($isEditingAvatar)
                        <input type="file" wire:model="image" id="avatar" accept="image/*" class="hidden">
                        <label for="avatar" class="cursor-pointer">
                            @if($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="Avatar Preview" class="w-24 h-24 rounded-full mx-auto cursor-pointer">
                            @elseif($contact->avatar)
                                <img src="{{ asset($contact->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full mx-auto cursor-pointer">
                            @else
                                <div class="w-24 h-24 border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto cursor-pointer">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            @endif
                        </label>
                        <div class="mt-2 text-center">
                            <button type="button" wire:click="cancelEditingAvatar" class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none">Cancel</button>
                        </div>
                    @else
                        <img src="{{ $contact->avatar ? asset($contact->avatar) : '' }}" alt="Avatar" class="w-24 h-24 rounded-full mx-auto cursor-pointer" wire:click="startEditingAvatar">
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <div class="flex items-center">
                    @if($editingField === 'name')
                        <input wire:model.defer="editValue" type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @else
                        <p class="text-gray-900">{{ $contact->name }}</p>
                    @endif
                    <button wire:click="editField('name')" type="button" class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h11a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 100 2h8a1 1 0 100-2H3zm0 4a1 1 0 011-1h8a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- NUMBERSS -->
            <div class="mt-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Numbers:</label>
    <ul class="list-disc list-inside">
        @foreach($numbers as $number)
            <li class="text-gray-900">
                @if($editingField === 'numbers.' . $number->id)
                    <input wire:model.defer="editNumberValues.{{ $number->id }}.number" type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @else
                    {{ $number->number }}
                    <button wire:click="editField('numbers.{{ $number->id }}')" type="button" class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h11a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 100 2h8a1 1 0 100-2H3zm0 4a1 1 0 011-1h8a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
            </li>
        @endforeach
    </ul>
</div>


            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <div class="flex items-center">
                    @if($editingField === 'email')
                        <input wire:model.defer="editValue" type="email" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @else
                        <p class="text-gray-900">{{ $contact->email ?: 'Not provided' }}</p>
                    @endif
                    <button wire:click="editField('email')" type="button" class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h11a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 100 2h8a1 1 0 100-2H3zm0 4a1 1 0 011-1h8a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                <div class="flex items-center">
                    @if($editingField === 'address')
                        <input wire:model.defer="editValue" type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @else
                        <p class="text-gray-900">{{ $contact->address ?: 'Not provided' }}</p>
                    @endif
                    <button wire:click="editField('address')" type="button" class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h11a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 100 2h8a1 1 0 100-2H3zm0 4a1 1 0 011-1h8a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Notes:</label>
                <div class="flex items-center">
                    @if($editingField === 'notes')
                        <textarea wire:model.defer="editValue" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    @else
                        <p class="text-gray-900">{{ $contact->notes ?: 'Not provided' }}</p>
                    @endif
                    <button wire:click="editField('notes')" type="button" class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h11a1 1 0 110 2H4a1 1 0 01-1-1zM3 9a1 1 0 100 2h8a1 1 0 100-2H3zm0 4a1 1 0 011-1h8a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                @if($editingField || $isEditingAvatar)
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Save</button>
                @endif
                <!-- You can add a Close button or manage modal toggling as needed -->
            </div>
        </div>
    </form>
</div>
