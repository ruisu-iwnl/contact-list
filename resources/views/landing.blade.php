@extends('layout')

@section('title', 'Contact List')

@section('content')
    <h1 class="text-3xl font-bold">contacts.</h1>
    <p class="text-lg">personalized contact book</p>
    <div class="mt-4">
        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">Login</a>
        <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Register</a>
    </div>
    
@endsection
