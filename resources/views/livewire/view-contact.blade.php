<div>
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
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
                <p class="text-gray-900">{{ $contact->name }}</p>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <p class="text-gray-900">{{ $contact->email ?: 'Not provided' }}</p>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Phone Numbers:</label>
                <ul class="list-disc ml-6">
                    @foreach($contact->numbers as $number)
                        <li>{{ $number->number }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                <p class="text-gray-900">{{ $contact->address ?: 'Not provided' }}</p>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Notes:</label>
                <p class="text-gray-900">{{ $contact->notes ?: 'Not provided' }}</p>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2" onclick="toggleModal('view-modal-id-{{ $loop->index }}')">Close</button>
            </div>
        </div>
    </form>
</div>
