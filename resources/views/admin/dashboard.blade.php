<x-admin-layout>
<x-slot name="title">Dashboard</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-bold" style="font-size:22px; color:#0b1c30;">Dashboard Overview</h2>
        <p class="text-sm mt-0.5" style="color:#514348;">
            Welcome back — here's what's happening today, {{ today()->format('l, F j') }}.
        </p>
    </div>
    <a href="{{ route('admin.appointments.create') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-white px-4 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
       style="background:#864461;">
        <span class="material-symbols-outlined" style="font-size:16px; font-variation-settings:'FILL' 1;">add_circle</span>
        New Booking
    </a>
</div>

{{-- ── Stat cards ──────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Today's appointments --}}
    <a href="{{ route('admin.appointments.index', ['date' => today()->toDateString()]) }}"
       class="group rounded-xl p-5 transition-all hover:-translate-y-0.5"
       style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#ffd9e5;">
                <span class="material-symbols-outlined" style="font-size:20px; color:#864461; font-variation-settings:'FILL' 1;">calendar_today</span>
            </div>
            <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:#bcedda; color:#204f41;">Today</span>
        </div>
        <div class="font-bold leading-none" style="font-size:30px; color:#0b1c30;">{{ $stats['today'] }}</div>
        <div class="text-sm mt-1" style="color:#514348;">Today's Appointments</div>
    </a>

    {{-- Upcoming --}}
    <a href="{{ route('admin.appointments.index') }}"
       class="group rounded-xl p-5 transition-all hover:-translate-y-0.5"
       style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#eddfe4;">
                <span class="material-symbols-outlined" style="font-size:20px; color:#664461; font-variation-settings:'FILL' 1;">event_repeat</span>
            </div>
            <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:#dce9ff; color:#514348;">Upcoming</span>
        </div>
        <div class="font-bold leading-none" style="font-size:30px; color:#0b1c30;">{{ $stats['upcoming'] }}</div>
        <div class="text-sm mt-1" style="color:#514348;">Upcoming</div>
    </a>

    {{-- Customers --}}
    <a href="{{ route('admin.customers.index') }}"
       class="group rounded-xl p-5 transition-all hover:-translate-y-0.5"
       style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#bcedda;">
                <span class="material-symbols-outlined" style="font-size:20px; color:#356253; font-variation-settings:'FILL' 1;">group</span>
            </div>
            <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:#bcedda; color:#356253;">Active</span>
        </div>
        <div class="font-bold leading-none" style="font-size:30px; color:#0b1c30;">{{ $stats['customers'] }}</div>
        <div class="text-sm mt-1" style="color:#514348;">Total Customers</div>
    </a>

    {{-- Revenue --}}
    <div class="rounded-xl p-5" style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#ffd9e5;">
                <span class="material-symbols-outlined" style="font-size:20px; color:#864461; font-variation-settings:'FILL' 1;">payments</span>
            </div>
            <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:#dce9ff; color:#514348;">{{ today()->format('M') }}</span>
        </div>
        <div class="font-bold leading-none" style="font-size:30px; color:#0b1c30;">R{{ number_format($stats['revenue'], 0) }}</div>
        <div class="text-sm mt-1" style="color:#514348;">Revenue This Month</div>
    </div>

</div>

{{-- ── Two-column cards ─────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    {{-- Today's Schedule --}}
    <div class="rounded-xl overflow-hidden flex flex-col"
         style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">

        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #eff4ff; background:#f8f9ff;">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:20px; color:#864461;">today</span>
                <h3 class="font-semibold" style="font-size:15px; color:#0b1c30;">Today's Schedule</h3>
            </div>
            <a href="{{ route('admin.appointments.index', ['date' => today()->toDateString()]) }}"
               class="text-xs font-semibold transition hover:opacity-70" style="color:#864461;">View all →</a>
        </div>

        @if($todayAppointments->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <span class="material-symbols-outlined mb-2" style="font-size:36px; color:#d6c1c7;">event_available</span>
                <p class="text-sm font-medium" style="color:#514348;">All clear today!</p>
                <p class="text-xs mt-1" style="color:#847378;">No appointments scheduled.</p>
            </div>
        @else
            <div class="divide-y" style="--tw-divide-opacity:1; border-color:#eff4ff;">
                @foreach($todayAppointments as $appt)
                @php
                    $isPast = $appt->starts_at->isPast();
                    $statusColors = [
                        'pending'   => ['bg'=>'#ffd9e5', 'text'=>'#864461'],
                        'confirmed' => ['bg'=>'#bcedda', 'text'=>'#204f41'],
                        'cancelled' => ['bg'=>'#dce9ff', 'text'=>'#514348'],
                        'completed' => ['bg'=>'#e5eeff', 'text'=>'#3a0522'],
                    ][$appt->status] ?? ['bg'=>'#dce9ff', 'text'=>'#514348'];
                @endphp
                <div class="flex items-center gap-4 px-5 py-3.5 {{ $isPast && $appt->status !== 'completed' ? 'opacity-60' : '' }}"
                     style="background:{{ $appt->status === 'completed' ? '#f8fefb' : 'white' }}">

                    {{-- Time block --}}
                    <div class="text-center w-14 shrink-0 px-2 py-2 rounded-xl" style="background:#ffd9e5;">
                        <div class="font-bold leading-none" style="font-size:16px; color:#3a0522;">{{ $appt->starts_at->format('g:i') }}</div>
                        <div class="text-xs mt-0.5" style="color:#70324e;">{{ $appt->starts_at->format('A') }}</div>
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                 style="background:#864461;">
                                {{ strtoupper(substr($appt->customer->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-sm truncate" style="color:#0b1c30;">{{ $appt->customer->name }}</span>
                        </div>
                        <div class="text-xs mt-1.5 flex items-center gap-2" style="color:#665c60;">
                            <span class="material-symbols-outlined" style="font-size:13px;">content_cut</span>
                            <span>{{ $appt->service->name }}</span>
                            <span style="color:#d6c1c7;">·</span>
                            <span>{{ $appt->staff->user->name }}</span>
                        </div>
                    </div>

                    {{-- Status + action --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full capitalize"
                              style="background:{{ $statusColors['bg'] }}; color:{{ $statusColors['text'] }};">
                            {{ $appt->status }}
                        </span>
                        @if(in_array($appt->status, ['pending', 'confirmed']) && $isPast)
                            <form method="POST" action="{{ route('admin.appointments.status', $appt) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit"
                                        class="text-xs font-semibold px-3 py-1.5 rounded-lg border transition-colors"
                                        style="color:#356253; border-color:#a0d1bf; background:white;"
                                        onmouseenter="this.style.background='#bcedda'"
                                        onmouseleave="this.style.background='white'">
                                    ✓ Done
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Upcoming Appointments --}}
    <div class="rounded-xl overflow-hidden flex flex-col"
         style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">

        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #eff4ff; background:#f8f9ff;">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:20px; color:#665c60;">upcoming</span>
                <h3 class="font-semibold" style="font-size:15px; color:#0b1c30;">Upcoming</h3>
            </div>
            <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:#eddfe4; color:#665c60;">Next 7 days</span>
        </div>

        @if($upcomingAppointments->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <span class="material-symbols-outlined mb-2" style="font-size:36px; color:#d6c1c7;">calendar_month</span>
                <p class="text-sm" style="color:#847378;">No upcoming appointments.</p>
            </div>
        @else
            <div class="divide-y" style="border-color:#eff4ff;">
                @foreach($upcomingAppointments as $appt)
                <div class="flex items-center gap-4 px-5 py-3.5 transition-colors"
                     style="background:white;"
                     onmouseenter="this.style.background='#f8f9ff'"
                     onmouseleave="this.style.background='white'">

                    {{-- Date block --}}
                    <div class="w-12 h-12 rounded-xl flex flex-col items-center justify-center shrink-0"
                         style="background:#e5eeff;">
                        <span class="uppercase tracking-wider" style="font-size:9px; font-weight:700; color:#514348;">
                            {{ $appt->starts_at->format('M') }}
                        </span>
                        <span class="font-bold leading-tight" style="font-size:18px; color:#0b1c30;">
                            {{ $appt->starts_at->format('j') }}
                        </span>
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-sm truncate" style="color:#0b1c30;">{{ $appt->customer->name }}</div>
                        <div class="text-xs mt-0.5" style="color:#665c60;">
                            {{ $appt->service->name }} · {{ $appt->starts_at->format('g:i A') }}
                        </div>
                    </div>

                    {{-- Status --}}
                    @php
                        $upColors = [
                            'pending'   => ['bg'=>'#ffd9e5', 'text'=>'#864461'],
                            'confirmed' => ['bg'=>'#bcedda', 'text'=>'#204f41'],
                        ][$appt->status] ?? ['bg'=>'#dce9ff', 'text'=>'#514348'];
                    @endphp
                    <div class="flex items-center gap-1.5 shrink-0">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full capitalize"
                              style="background:{{ $upColors['bg'] }}; color:{{ $upColors['text'] }};">
                            {{ $appt->status }}
                        </span>
                        <span class="material-symbols-outlined" style="font-size:16px; color:#d6c1c7;">chevron_right</span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
</x-admin-layout>
