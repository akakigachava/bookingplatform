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
        <div class="max-w-6xl mx-auto pr-4 sm:pr-6 lg:pr-8 pl-2 sm:pl-3">
            <div class="flex justify-between h-16 items-center">

                {{-- LEFT: Avatar (auth) or Logo (guest) --}}
                <div class="flex items-center gap-3">
                    @auth
                        {{-- Avatar dropdown on the LEFT --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center gap-2 px-2 py-1.5 rounded-xl border border-gray-200 bg-white hover:border-pink-300 hover:shadow-sm transition-all duration-150 focus:outline-none">

                                {{-- Avatar circle --}}
                                <div class="relative">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                             alt="{{ auth()->user()->name }}"
                                             class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm">
                                    @else
                                        @php
                                            $parts    = explode(' ', trim(auth()->user()->name));
                                            $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr($parts[1] ?? '', 0, 1));
                                        @endphp
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center ring-2 ring-white shadow-sm text-white text-xs font-bold"
                                             style="background: linear-gradient(135deg, #b5708a, #8b4a6b);">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                    <span class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border-2 border-white"></span>
                                </div>

                                {{-- Name --}}
                                <div class="text-left hidden sm:block">
                                    <p class="text-xs font-semibold text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 leading-tight">{{ auth()->user()->email }}</p>
                                </div>

                                {{-- Chevron --}}
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            {{-- Dropdown opens to the RIGHT from left corner --}}
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                                 style="display: none;">

                                {{-- User info header --}}
                                <div class="px-4 py-3 border-b border-gray-50" style="background: linear-gradient(135deg, #fdf2f6, #faf5ff);">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                {{-- Menu items --}}
                                <div class="p-1.5">
                                    <a href="{{ route('profile.edit') }}"
                                       class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profile
                                    </a>
                                    <a href="{{ route('customer.bookings') }}"
                                       class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        My Bookings
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endauth

                    {{-- Logo always visible --}}
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#b5708a">
                            <span class="text-white font-bold text-sm">B</span>
                        </div>
                        <span class="font-semibold text-gray-900 text-lg">BookEase</span>
                    </a>
                </div>

                {{-- RIGHT: Nav links --}}
                <div class="flex items-center gap-2">
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                            <a href="{{ route('admin.dashboard') }}"
                               class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-50 transition">Dashboard</a>
                        @else
                            <a href="{{ route('customer.bookings') }}"
                               class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-50 transition">My Bookings</a>
                        @endif

                        <a href="{{ route('book') }}"
                           class="text-sm font-medium text-white px-4 py-2 rounded-lg transition hover:opacity-90"
                           style="background:#b5708a">Book Now</a>

                        {{-- Visible logout button --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    title="Sign out"
                                    class="flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-red-600 px-3 py-2 rounded-lg hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden sm:inline">Sign out</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2">Log in</a>
                        <a href="{{ route('register') }}"
                           class="text-sm font-medium text-white px-4 py-2 rounded-lg transition hover:opacity-90"
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
