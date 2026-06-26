<x-admin-layout>
<x-slot name="title">Dashboard</x-slot>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    <a href="{{ route('admin.appointments.index', ['date' => today()->toDateString()]) }}"
       class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-[#b5708a]/30 transition-colors">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3" style="background:#b5708a22">
            <svg class="w-5 h-5" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['today'] }}</div>
        <div class="text-xs text-gray-400 mt-0.5">Today's Appointments</div>
    </a>

    <a href="{{ route('admin.appointments.index') }}"
       class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-[#7c8a5a]/30 transition-colors">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3" style="background:#7c8a5a22">
            <svg class="w-5 h-5" style="color:#7c8a5a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['upcoming'] }}</div>
        <div class="text-xs text-gray-400 mt-0.5">Upcoming</div>
    </a>

    <a href="{{ route('admin.customers.index') }}"
       class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-[#5a7a8a]/30 transition-colors">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3" style="background:#5a7a8a22">
            <svg class="w-5 h-5" style="color:#5a7a8a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['customers'] }}</div>
        <div class="text-xs text-gray-400 mt-0.5">Total Customers</div>
    </a>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3" style="background:#8a5a7a22">
            <svg class="w-5 h-5" style="color:#8a5a7a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="text-2xl font-bold text-gray-900">R{{ number_format($stats['revenue'], 0) }}</div>
        <div class="text-xs text-gray-400 mt-0.5">Revenue This Month</div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Today's Appointments --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800 text-sm">Today's Schedule</h2>
            <a href="{{ route('admin.appointments.index', ['date' => today()->toDateString()]) }}"
               class="text-xs font-medium" style="color:#b5708a">View all</a>
        </div>
        @if($todayAppointments->isEmpty())
            <div class="text-center py-10 text-sm text-gray-400">No appointments today.</div>
        @else
            <div class="divide-y divide-gray-50">
                @foreach($todayAppointments as $appt)
                @php
                    $badge = ['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-green-100 text-green-700','cancelled'=>'bg-gray-100 text-gray-500','completed'=>'bg-blue-100 text-blue-700'][$appt->status] ?? '';
                @endphp
                <div class="flex items-center justify-between px-6 py-3">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $appt->customer->name }}</div>
                        <div class="text-xs text-gray-400">
                            {{ $appt->service->name }} &middot; {{ $appt->starts_at->format('g:i A') }} &middot; {{ $appt->staff->user->name }}
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badge }} capitalize">{{ $appt->status }}</span>
                        @if(in_array($appt->status, ['pending', 'confirmed']) && $appt->starts_at->isPast())
                            <form method="POST" action="{{ route('admin.appointments.status', $appt) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit"
                                        class="text-xs font-medium text-green-600 border border-green-200 px-2.5 py-1 rounded-lg bg-white hover:bg-green-50 transition-colors">
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
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800 text-sm">Upcoming</h2>
            <a href="{{ route('admin.appointments.index') }}"
               class="text-xs font-medium" style="color:#b5708a">View all</a>
        </div>
        @if($upcomingAppointments->isEmpty())
            <div class="text-center py-10 text-sm text-gray-400">No upcoming appointments.</div>
        @else
            <div class="divide-y divide-gray-50">
                @foreach($upcomingAppointments as $appt)
                @php
                    $badge = ['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-green-100 text-green-700','cancelled'=>'bg-gray-100 text-gray-500','completed'=>'bg-blue-100 text-blue-700'][$appt->status] ?? '';
                @endphp
                <div class="flex items-center justify-between px-6 py-3">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $appt->customer->name }}</div>
                        <div class="text-xs text-gray-400">
                            {{ $appt->starts_at->format('M j, g:i A') }} &middot; {{ $appt->service->name }}
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badge }} capitalize">{{ $appt->status }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
</x-admin-layout>
