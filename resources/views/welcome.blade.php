<x-app-layout>

{{-- Hero --}}
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, #b5708a 0%, #c98aa5 50%, #e0b4c8 100%);">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <h1 class="text-4xl sm:text-5xl font-bold text-white leading-tight mb-4">
            Book Your Perfect<br>Appointment
        </h1>
        <p class="text-lg text-white/80 mb-8 max-w-xl mx-auto">
            Effortless scheduling for salons, barbershops &amp; spas.
            Find your time, choose your style.
        </p>
        @auth
            <a href="{{ route('book') }}"
               class="inline-block bg-white font-semibold px-8 py-3 rounded-xl shadow-lg text-sm transition hover:shadow-xl"
               style="color:#b5708a">
                Book an Appointment &rarr;
            </a>
        @else
            <div class="flex justify-center gap-3 flex-wrap">
                <a href="{{ route('register') }}"
                   class="inline-block bg-white font-semibold px-8 py-3 rounded-xl shadow-lg text-sm transition hover:shadow-xl"
                   style="color:#b5708a">
                    Get Started — It's Free
                </a>
                <a href="{{ route('login') }}"
                   class="inline-block bg-white/20 text-white font-medium px-6 py-3 rounded-xl text-sm border border-white/30 hover:bg-white/30 transition">
                    Log in
                </a>
            </div>
        @endauth
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 48L1440 48L1440 24C1200 48 960 0 720 24C480 48 240 0 0 24Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

{{-- Services --}}
@if($services->isNotEmpty())
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-gray-900">Our Services</h2>
        <p class="text-gray-500 mt-1 text-sm">Pick what you need — we'll handle the rest.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($services as $service)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="w-10 h-10 rounded-xl mb-4 flex items-center justify-center" style="background:rgba(181,112,138,0.12)">
                <svg class="w-5 h-5" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 text-lg">{{ $service->name }}</h3>
            @if($service->description)
                <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $service->description }}</p>
            @endif
            <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-gray-400 bg-gray-100 rounded-full px-2 py-1">{{ $service->duration_minutes }} min</span>
                <span class="font-bold text-gray-900">R{{ number_format($service->price, 2) }}</span>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-8">
        @auth
            <a href="{{ route('book') }}"
               class="inline-block text-white font-medium px-6 py-3 rounded-xl text-sm transition"
               style="background:#b5708a">Book a Service &rarr;</a>
        @else
            <a href="{{ route('register') }}"
               class="inline-block text-white font-medium px-6 py-3 rounded-xl text-sm transition"
               style="background:#b5708a">Sign up to Book &rarr;</a>
        @endauth
    </div>
</section>
@endif

{{-- Staff --}}
@if($staff->isNotEmpty())
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-900">Meet Our Team</h2>
            <p class="text-gray-500 mt-1 text-sm">Skilled professionals ready to serve you.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($staff as $member)
            <div class="text-center">
                <div class="w-20 h-20 rounded-full mx-auto mb-3 flex items-center justify-center text-white font-bold text-2xl shadow"
                     style="background: linear-gradient(135deg, #b5708a, #d4a0b8)">
                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                </div>
                <div class="font-semibold text-gray-800 text-sm">{{ $member->user->name }}</div>
                @if($member->bio)
                    <p class="text-xs text-gray-400 mt-1 leading-relaxed line-clamp-2">{{ $member->bio }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- How it works --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-gray-900">How It Works</h2>
        <p class="text-gray-500 mt-1 text-sm">Three simple steps to your perfect appointment.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
        @foreach([
            ['1', 'Choose a Service', 'Browse our menu and pick the treatment you want.'],
            ['2', 'Select a Time Slot', 'See live availability and book in seconds.'],
            ['3', 'Show Up & Enjoy', 'Get a confirmation email — just arrive on time!'],
        ] as [$num, $title, $desc])
        <div>
            <div class="w-12 h-12 rounded-full text-white font-bold text-lg flex items-center justify-center mx-auto mb-4 shadow"
                 style="background:#b5708a">{{ $num }}</div>
            <h3 class="font-semibold text-gray-800 mb-1">{{ $title }}</h3>
            <p class="text-gray-500 text-sm">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- CTA for guests --}}
@guest
<section class="py-16" style="background: linear-gradient(135deg, #b5708a, #c98aa5)">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-white mb-2">Ready to book?</h2>
        <p class="text-white/80 mb-6 text-sm">Create a free account and make your first appointment today.</p>
        <a href="{{ route('register') }}"
           class="inline-block bg-white font-semibold px-8 py-3 rounded-xl shadow text-sm hover:shadow-lg transition"
           style="color:#b5708a">Sign Up Free &rarr;</a>
    </div>
</section>
@endguest

</x-app-layout>
