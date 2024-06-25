<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Contact List')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    @vite('resources/css/app.css') {{-- Assuming this includes your Vite CSS bundle --}}
    @livewireStyles {{-- Include Livewire styles --}}
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <main class="py-4 text-center">
            @yield('content')
        </main>
    </div>

    @livewireScripts {{-- Include Livewire scripts --}}
</body>
</html>