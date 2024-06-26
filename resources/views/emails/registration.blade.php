@extends('layout')

@section('title', 'Registration Successful')

@section('content')
    <h1 class="text-3xl font-bold">Welcome, {{ $user->username }}</h1>
    <p class="text-lg">Thank you for registering!</p>
@endsection
