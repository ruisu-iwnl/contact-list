<div>
    <form wire:submit.prevent="saveEdit" enctype="multipart/form-data">
        @csrf
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-md mx-auto">
            <header class="py-4 text-center">
                <h1 class="text-3xl font-bold">Contact Details</h1>
            </header>
            <div class="flex justify-center mb-6">
                <div class="relative">
                    @if($contact->avatar)
                        <img src="{{ asset($contact->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full mx-auto">
                    @else
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
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
                @if($editingField)
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Save</button>
                @endif
                <!-- this seems to be not working so i moved it to dashboard -->
                <!-- <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" onclick="toggleModal('view-modal-id')">Close</button> -->
            </div>
        </div>
    </form>
</div>
