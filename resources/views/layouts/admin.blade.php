<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — {{ config('app.name', 'BookEase') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background:#f8f9ff; color:#0b1c30;" x-data="{ sidebarOpen: false }">

{{-- Mobile overlay --}}
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 z-30 lg:hidden"
     style="background:rgba(0,0,0,0.4); display:none">
</div>

{{-- ── Sidebar ──────────────────────────────────────────────────────────── --}}
<aside class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 transition-transform duration-200 ease-in-out"
       style="background:#f8f9ff; border-right:1px solid #d6c1c7;"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 shrink-0" style="border-bottom:1px solid #d6c1c7;">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0"
                 style="background:#a35c7a;">
                <span class="material-symbols-outlined text-white"
                      style="font-size:22px; font-variation-settings:'FILL' 1;">book_online</span>
            </div>
            <div>
                <div class="font-bold leading-none" style="font-size:17px; color:#864461;">BookEase</div>
                <div class="uppercase tracking-wider mt-0.5" style="font-size:9px; color:#514348; letter-spacing:0.08em;">Service Management</div>
            </div>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

        @php
            $navItem = function(string $routeName, string $label, string $icon) {
                $active = request()->routeIs($routeName . '*');
                if ($active) {
                    $cls   = 'flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors border-r-4';
                    $style = 'color:#864461; background:#eddfe4; border-color:#864461';
                    $iStyle = "font-size:20px; font-variation-settings:'FILL' 1";
                    $hover = '';
                } else {
                    $cls   = 'flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors border-r-4 border-transparent';
                    $style = 'color:#665c60';
                    $iStyle = 'font-size:20px';
                    $hover = ' onmouseenter="this.style.background=\'#eff4ff\'" onmouseleave="this.style.background=\'\'"';
                }
                return '<a href="' . route($routeName) . '" class="' . $cls . '" style="' . $style . '"' . $hover . '>'
                    . '<span class="material-symbols-outlined" style="' . $iStyle . '">' . $icon . '</span>'
                    . '<span>' . e($label) . '</span>'
                    . '</a>';
            };
        @endphp

        <div class="px-4 pb-1 pt-0.5">
            <span class="uppercase tracking-widest" style="font-size:10px; font-weight:600; color:#d6c1c7;">Main</span>
        </div>

        {!! $navItem('admin.dashboard',          'Dashboard',      'dashboard') !!}
        {!! $navItem('admin.appointments.index', 'Appointments',   'calendar_month') !!}

        @if(auth()->user()->isStaff() && !auth()->user()->isAdmin())
            {!! $navItem('admin.schedule', 'My Schedule', 'checklist') !!}
        @endif

        {!! $navItem('admin.customers.index', 'Customers', 'group') !!}

        @if(auth()->user()->isAdmin())
            <div class="px-4 pb-1 pt-3">
                <span class="uppercase tracking-widest" style="font-size:10px; font-weight:600; color:#d6c1c7;">Admin</span>
            </div>
            {!! $navItem('admin.services.index', 'Services', 'category') !!}
            {!! $navItem('admin.staff.index',    'Staff',    'badge') !!}
        @endif

        {!! $navItem('admin.business-hours.index', 'Business Hours', 'schedule') !!}

    </nav>

    {{-- New Appointment CTA --}}
    <div class="px-3 pb-3 shrink-0">
        <a href="{{ route('admin.appointments.create') }}"
           class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-semibold text-white shadow-md transition hover:opacity-90 active:scale-95"
           style="background:#864461;">
            <span class="material-symbols-outlined" style="font-size:18px; font-variation-settings:'FILL' 1;">add_circle</span>
            New Appointment
        </a>
    </div>

    {{-- User section --}}
    <div class="px-3 py-3 shrink-0" style="border-top:1px solid #d6c1c7;">
        <div class="flex items-center gap-3 p-3 rounded-xl" style="background:#ffd9e5;">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                 style="background:#864461;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-xs font-semibold truncate leading-tight" style="color:#3a0522;">
                    {{ auth()->user()->name }}
                </div>
                <div class="capitalize leading-tight mt-0.5" style="font-size:10px; color:#70324e;">
                    {{ auth()->user()->role }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button type="submit" title="Log out"
                        class="p-1.5 rounded-lg transition-colors"
                        style="color:#864461;"
                        onmouseenter="this.style.background='#ffb0ce'"
                        onmouseleave="this.style.background=''">
                    <span class="material-symbols-outlined" style="font-size:18px;">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ── Main Content ──────────────────────────────────────────────────────── --}}
<div class="lg:ml-64 flex flex-col min-h-screen">

    {{-- Top header --}}
    <header class="sticky top-0 z-30 flex items-center justify-between px-5 h-16 shrink-0"
            style="background:#ffffff; border-bottom:1px solid #d3e4fe; box-shadow:0 1px 3px rgba(0,0,0,0.06);">

        {{-- Left: hamburger + search --}}
        <div class="flex items-center gap-3 flex-1">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2 rounded-xl transition-colors"
                    style="color:#514348;"
                    onmouseenter="this.style.background='#eff4ff'"
                    onmouseleave="this.style.background=''">
                <span class="material-symbols-outlined" style="font-size:22px;">menu</span>
            </button>
            <div class="relative hidden md:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2"
                      style="font-size:18px; color:#514348;">search</span>
                <input type="text" placeholder="Search appointments, customers…"
                       class="pl-9 pr-4 py-2 rounded-full text-sm border-0 w-72 focus:outline-none focus:ring-2 transition"
                       style="background:#eff4ff; --tw-ring-color:#864461;">
            </div>
        </div>

        {{-- Right: notifications + user --}}
        <div class="flex items-center gap-1.5">
            <button class="w-9 h-9 flex items-center justify-center rounded-full transition-colors"
                    style="color:#514348;"
                    onmouseenter="this.style.background='#eff4ff'"
                    onmouseleave="this.style.background=''">
                <span class="material-symbols-outlined" style="font-size:20px;">notifications</span>
            </button>
            <div class="w-px h-6 mx-1.5" style="background:#d6c1c7;"></div>
            <div class="flex items-center gap-2.5">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-semibold leading-tight" style="color:#0b1c30;">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="capitalize leading-tight" style="font-size:10px; color:#514348;">
                        {{ auth()->user()->role }}
                    </div>
                </div>
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0"
                     style="background:#864461;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mx-6 mt-4 flex items-center gap-3 px-4 py-3 rounded-xl text-sm"
             style="background:#bcedda; color:#002118; border:1px solid #a0d1bf;">
            <span class="material-symbols-outlined shrink-0" style="font-size:18px; color:#356253;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mx-6 mt-4 flex items-center gap-3 px-4 py-3 rounded-xl text-sm"
             style="background:#ffdad6; color:#93000a; border:1px solid #f9b4af;">
            <span class="material-symbols-outlined shrink-0" style="font-size:18px; color:#ba1a1a;">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Page content --}}
    <main class="flex-1 px-6 py-6 lg:px-8 lg:py-7">
        {{ $slot }}
    </main>
</div>

</body>
</html>
