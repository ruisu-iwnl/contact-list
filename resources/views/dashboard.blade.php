@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Contact List</h1>
    
    {{-- Search Bar --}}
    <div class="flex mb-4 space-x-2">
        <input type="text" placeholder="Search..." class="flex-grow p-1 h-9 w-32 border rounded-l-md">
        <button class="p-2 bg-blue-500 text-white p-1 h-9 w-30 rounded">Search</button>
        <button class="p-2 bg-green-500 text-white p-1 h-9 w-30 rounded" onclick="toggleModal('modal-id')">Add Contact</button>
    </div>

    {{-- Contact List Table --}}
    <table class="table-auto w-full bg-white shadow-md rounded mb-4">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Phone Number</th>
                <th class="px-4 py-2">Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td class="border px-4 py-2">{{ $contact->name }}</td>
                    <td class="border px-4 py-2">
                        @foreach($contact->numbers as $number)
                            {{ $number->number }}<br>
                        @endforeach
                    </td>
                    <td class="border px-4 py-2">
                        <a href="#" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded" onclick="toggleModal('view-modal-id-{{ $loop->index }}')">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table><br><br>
    
    {{-- Logout Button --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Logout</button>
    </form>
</div>

{{-- Add Contact Modal --}}
<div id="modal-id" class="fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full hidden flex justify-center items-center p-20">
    <div class="mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Add Contact</h3>
            <div class="mt-2">
                @livewire('add-contact-form')
            </div>
        </div>
    </div>
</div>

@foreach($contacts as $contact)
    {{-- View Contact Modal --}}
    <div id="view-modal-id-{{ $loop->index }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full hidden flex justify-center items-center p-20">
        <div class="mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">View Contact</h3>
                <div class="mt-2">
                    @livewire('view-contact', ['contact' => $contact], key($contact->id))
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" onclick="toggleModal('view-modal-id-{{ $loop->index }}')">Close</button>
            </div>
        </div>
    </div>
@endforeach

<script>
    function toggleModal(modalID) {
        document.getElementById(modalID).classList.toggle("hidden");
        document.getElementById(modalID).classList.toggle("flex");
    }
</script>
@endsection
