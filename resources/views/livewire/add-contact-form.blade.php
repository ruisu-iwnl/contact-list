<div>
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-md mx-auto">
            <header class="py-4 text-center">
                <h1 class="text-3xl font-bold">Add Contact</h1>
            </header>

            <div class="flex justify-center mb-3">
                <label for="image" class="cursor-pointer">
                    @if($image)
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-full overflow-hidden">
                            <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full" alt="Uploaded Image">
                        </div>
                    @else
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                    @endif
                    <input wire:model="image" type="file" name="image" id="image" class="hidden" accept=".png, .jpeg, .jpg">
                </label>
                
            </div>
            <p class="text-sm text-gray-600">Maximum size is 25MB</p><br>


            <input wire:model="name" type="text" name="name" placeholder="Name" class="w-full p-2 mb-3 border rounded">
            @error('name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror

            <input wire:model="email" type="email" name="email" placeholder="Email" class="w-full p-2 mb-3 border rounded">
            @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror

            <div>
                @foreach($numbers as $index => $number)
                    <div class="flex items-center mb-2">
                        <input wire:model="numbers.{{ $index }}" type="text" name="numbers[]" placeholder="Phone Number" class="w-full p-2 border rounded">
                        @if($loop->first)
                            <button type="button" wire:click="addNumber" class="ml-2 bg-blue-500 text-white p-2 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        @else
                            <button type="button" wire:click="removeNumber({{ $index }})" class="ml-2 bg-red-500 text-white p-2 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        @endif
                    </div>
                    @error('numbers.' . $index)
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                @endforeach
            </div>

            <textarea wire:model="address" name="address" placeholder="Address" class="w-full p-2 mb-3 border rounded resize-none"></textarea>
            @error('address')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror

            <textarea wire:model="notes" name="notes" placeholder="Notes" class="w-full p-2 mb-3 border rounded resize-none"></textarea>
            @error('notes')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror

            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2" onclick="toggleModal('modal-id')">Cancel</button>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Save</button>
            </div>

            @if (session()->has('error'))
                <p class="text-red-500 text-xs italic mt-2">{{ session('error') }}</p>
            @endif
        </div>
    </form>
</div>
