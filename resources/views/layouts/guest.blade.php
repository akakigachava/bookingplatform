<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BookEase') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background:#f8f9ff;">

<div class="min-h-screen flex">

    {{-- ── Left brand panel ──────────────────────────────────────────── --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[45%] relative flex-col justify-between p-12 overflow-hidden"
         style="background: linear-gradient(145deg, #864461 0%, #5a2a3e 60%, #3a0522 100%);">

        {{-- Decorative circles --}}
        <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full" style="background:rgba(255,255,255,0.05);"></div>
        <div class="absolute top-16 -right-10 w-52 h-52 rounded-full" style="background:rgba(255,255,255,0.04);"></div>
        <div class="absolute -top-12 left-1/2 w-40 h-40 rounded-full" style="background:rgba(255,255,255,0.04);"></div>
        <div class="absolute bottom-1/3 -left-12 w-36 h-36 rounded-full" style="background:rgba(255,255,255,0.06);"></div>

        {{-- Top: Logo --}}
        <div class="relative z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center"
                     style="background:rgba(255,255,255,0.15); backdrop-filter:blur(8px);">
                    <span class="material-symbols-outlined text-white"
                          style="font-size:22px; font-variation-settings:'FILL' 1;">book_online</span>
                </div>
                <span class="text-white font-bold" style="font-size:20px; letter-spacing:-0.02em;">BookEase</span>
            </a>
        </div>

        {{-- Middle: Headline + features --}}
        <div class="relative z-10">
            <h1 class="text-white font-extrabold leading-tight mb-4"
                style="font-size:36px; letter-spacing:-0.03em;">
                Appointments,<br>simplified.
            </h1>
            <p class="mb-10" style="color:rgba(255,209,225,0.8); font-size:15px; line-height:1.6;">
                The booking platform for salons, barbershops, and spas that care about their customers.
            </p>

            <div class="space-y-4">
                @foreach([
                    ['check_circle', 'Book in seconds', 'Customers choose their service, staff, and time slot.'],
                    ['event_available', 'Zero double bookings', 'Real-time slot availability prevents conflicts.'],
                    ['notifications_active', 'Always in control', 'Manage staff, hours, and walk-ins from one place.'],
                ] as [$icon, $title, $desc])
                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center"
                         style="background:rgba(255,255,255,0.12);">
                        <span class="material-symbols-outlined text-white" style="font-size:18px; font-variation-settings:'FILL' 1;">{{ $icon }}</span>
                    </div>
                    <div>
                        <div class="font-semibold text-white text-sm">{{ $title }}</div>
                        <div class="text-xs mt-0.5" style="color:rgba(255,209,225,0.7);">{{ $desc }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Bottom: Testimonial --}}
        <div class="relative z-10 p-5 rounded-2xl" style="background:rgba(255,255,255,0.08); backdrop-filter:blur(8px);">
            <p class="text-sm italic" style="color:rgba(255,225,235,0.9); line-height:1.6;">
                "BookEase made managing our salon appointments so much easier. No more missed bookings or phone calls."
            </p>
            <div class="flex items-center gap-3 mt-4">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold"
                     style="background:rgba(255,255,255,0.2); color:white;">S</div>
                <div>
                    <div class="text-xs font-semibold text-white">Sarah Johnson</div>
                    <div class="text-xs" style="color:rgba(255,209,225,0.6);">Salon Owner</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right form panel ──────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 lg:px-16" style="background:#ffffff;">

        {{-- Mobile logo (hidden on desktop) --}}
        <div class="lg:hidden mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                     style="background:#864461;">
                    <span class="material-symbols-outlined text-white" style="font-size:20px; font-variation-settings:'FILL' 1;">book_online</span>
                </div>
                <span class="font-bold text-lg" style="color:#864461;">BookEase</span>
            </a>
        </div>

        <div class="w-full max-w-md">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="mt-10 text-xs" style="color:#d6c1c7;">
            © {{ date('Y') }} BookEase. All rights reserved.
        </p>
    </div>

</div>

</body>
</html>
