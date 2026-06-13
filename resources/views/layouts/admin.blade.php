<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — {{ config('app.name', 'BookEase') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background:#f9f8f7">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    {{-- ── Mobile overlay ────────────────────────────────────────────── --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-black/30 backdrop-blur-sm lg:hidden"
         style="display:none">
    </div>

    {{-- ── Sidebar ─────────────────────────────────────────────────────── --}}
    <aside class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 bg-white border-r border-gray-100
                  transition-transform duration-200 ease-in-out
                  lg:relative lg:translate-x-0 lg:flex lg:shrink-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Logo --}}
        <div class="h-16 flex items-center px-5 shrink-0" style="border-bottom:1px solid #f0eff0">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center shadow-sm shrink-0"
                     style="background: linear-gradient(135deg,#b5708a,#c98aa5)">
                    <span class="text-white font-bold text-sm tracking-tight">B</span>
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-900 leading-none">BookEase</div>
                    <div class="text-[10px] text-gray-400 leading-none mt-0.5">Admin Panel</div>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            @php
                $navItem = function(string $routeName, string $label, string $iconPath) {
                    $active = request()->routeIs($routeName . '*');
                    $base   = 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors duration-150 group';
                    $state  = $active
                        ? 'text-[#b5708a] bg-[#b5708a]/10'
                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50';
                    $icon   = '<svg class="w-4 h-4 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' . $iconPath . '"/>
                               </svg>';
                    return '<a href="' . route($routeName) . '" class="' . $base . ' ' . $state . '">'
                        . $icon . '<span>' . e($label) . '</span>'
                        . ($active ? '<span class="ml-auto w-1.5 h-1.5 rounded-full shrink-0" style="background:#b5708a"></span>' : '')
                        . '</a>';
                };
            @endphp

            <div class="px-2 pb-1 pt-0.5">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-gray-300">Main</span>
            </div>

            {!! $navItem('admin.dashboard',    'Dashboard',
                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6') !!}

            {!! $navItem('admin.appointments.index', 'Appointments',
                'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z') !!}

            @if(auth()->user()->isAdmin())
                <div class="px-2 pb-1 pt-3">
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-gray-300">Admin</span>
                </div>

                {!! $navItem('admin.services.index', 'Services',
                    'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2') !!}

                {!! $navItem('admin.staff.index', 'Staff',
                    'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z') !!}
            @endif

            {!! $navItem('admin.business-hours.index', 'Business Hours',
                'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z') !!}

        </nav>

        {{-- User section --}}
        <div class="px-3 py-4 shrink-0" style="border-top:1px solid #f0eff0">
            <div class="flex items-center gap-3 px-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0
                            text-white text-xs font-bold shadow-sm"
                     style="background: linear-gradient(135deg,#b5708a,#c98aa5)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-sm font-semibold text-gray-800 truncate leading-tight">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-[11px] text-gray-400 capitalize leading-tight mt-0.5">
                        {{ auth()->user()->role }}
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit" title="Log out"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── Content column ─────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-auto">

        {{-- Mobile-only top bar --}}
        <div class="lg:hidden flex items-center gap-3 px-4 h-14 bg-white shrink-0"
             style="border-bottom:1px solid #f0eff0">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg flex items-center justify-center"
                     style="background: linear-gradient(135deg,#b5708a,#c98aa5)">
                    <span class="text-white font-bold text-xs">B</span>
                </div>
                <span class="font-semibold text-sm text-gray-900">BookEase</span>
            </div>
        </div>

        {{-- Main content — no extra header bar, content starts here --}}
        <main class="flex-1 px-6 py-6 lg:px-8 lg:py-7">

            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200
                            text-green-800 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200
                            text-red-800 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-4 h-4 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}

        </main>
    </div>

</div>
</body>
</html>
