<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BookEase') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#b5708a">
                        <span class="text-white font-bold text-sm">B</span>
                    </div>
                    <span class="font-semibold text-gray-900 text-lg">BookEase</span>
                </a>

                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                            <a href="{{ route('admin.dashboard') }}"
                               class="text-sm font-medium text-gray-600 hover:text-gray-900">Dashboard</a>
                        @else
                            <a href="{{ route('customer.bookings') }}"
                               class="text-sm font-medium text-gray-600 hover:text-gray-900">My Bookings</a>
                        @endif
                        <a href="{{ route('book') }}"
                           class="text-sm font-medium text-white px-4 py-2 rounded-lg transition"
                           style="background:#b5708a">Book Now</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-800">Log out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Log in</a>
                        <a href="{{ route('register') }}"
                           class="text-sm font-medium text-white px-4 py-2 rounded-lg transition"
                           style="background:#b5708a">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main>{{ $slot }}</main>

    <footer class="bg-white border-t border-gray-100 mt-16 py-8 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} BookEase. All rights reserved.
    </footer>
</body>
</html>
