<div>
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
        @csrf

        <!-- Image Upload -->
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

        <!-- Name Input -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input wire:model="name" id="name" type="text" name="name" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Input -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input wire:model="email" id="email" type="email" name="email" placeholder="Email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone Numbers -->
        <div>
            @foreach($numbers as $index => $number)
            <div class="mb-4">
                <label for="number{{ $index }}" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                <input wire:model="numbers.{{ $index }}" id="number{{ $index }}" type="text" name="numbers[]" placeholder="Phone Number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('numbers.' . $index)
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>

        <!-- Address Textarea -->
        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
            <textarea wire:model="address" id="address" name="address" placeholder="Address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none"></textarea>
            @error('address')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Notes Textarea -->
        <div class="mb-6">
            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
            <textarea wire:model="notes" id="notes" name="notes" placeholder="Notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none"></textarea>
            @error('notes')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Buttons -->
        <div class="flex justify-end">
            <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2" onclick="toggleModal('modal-id')">Cancel</button>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Save</button>
        </div>

        <!-- Global Error Message -->
        @if ($errors->has('error'))
            <p class="text-red-500 text-xs italic mt-2">{{ $errors->first('error') }}</p>
        @endif
    </form>
</div>
