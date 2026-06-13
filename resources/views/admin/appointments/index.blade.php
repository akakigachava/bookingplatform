<x-admin-layout>
<x-slot name="title">Appointments</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Appointments</h2>
        <p class="text-sm text-gray-400 mt-0.5">View and manage all customer bookings.</p>
    </div>
    <div class="flex items-center gap-3">
        @if($appointments->total() > 0)
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-white border border-gray-200 text-gray-500 shadow-sm">
                {{ $appointments->total() }} {{ Str::plural('booking', $appointments->total()) }}
            </span>
        @endif
        <a href="{{ route('admin.appointments.create') }}"
           class="inline-flex items-center gap-1.5 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
           style="background:#b5708a">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            New Booking
        </a>
    </div>
</div>

{{-- Filter card --}}
<div class="bg-white rounded-2xl border border-gray-100 mb-5 overflow-hidden"
     style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.05)">
    <div class="px-6 py-4" style="border-bottom:1px solid #f5f4f4">
        <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Filter</span>
    </div>
    <form method="GET" class="px-6 py-4 flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1.5">Date</label>
            <input type="date" name="date" value="{{ request('date') }}"
                   class="border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:border-transparent transition"
                   style="--tw-ring-color:#b5708a">
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1.5">Status</label>
            <select name="status"
                    class="border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 bg-white appearance-none pr-8 focus:outline-none focus:ring-2 focus:border-transparent transition cursor-pointer"
                    style="--tw-ring-color:#b5708a; background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E\"); background-repeat:no-repeat; background-position:right 10px center">
                <option value="">All Statuses</option>
                @foreach(['pending','confirmed','cancelled','completed'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                    class="inline-flex items-center gap-1.5 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm transition hover:opacity-90"
                    style="background:#b5708a">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Apply
            </button>
            @if(request()->anyFilled(['date','status']))
                <a href="{{ route('admin.appointments.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-gray-700 px-4 py-2 rounded-xl border border-gray-200 bg-white hover:border-gray-300 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Table card --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
     style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

    @if($appointments->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-5"
                 style="background:rgba(181,112,138,0.1)">
                <svg class="w-8 h-8" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800">
                {{ request()->anyFilled(['date','status']) ? 'No appointments match your filters' : 'No appointments yet' }}
            </p>
            <p class="text-xs text-gray-400 mt-1 mb-5">
                {{ request()->anyFilled(['date','status']) ? 'Try a different date or status.' : 'Appointments will appear here once customers start booking.' }}
            </p>
            @if(request()->anyFilled(['date','status']))
                <a href="{{ route('admin.appointments.index') }}"
                   class="text-white text-xs font-semibold px-4 py-2 rounded-lg transition hover:opacity-90"
                   style="background:#b5708a">Clear Filters</a>
            @endif
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#fafafa; border-bottom:1px solid #f0eff0">
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Staff</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date &amp; Time</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appt)
                @php
                    $badge = [
                        'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                        'confirmed' => 'bg-green-50 text-green-700 border-green-200',
                        'cancelled' => 'bg-gray-100 text-gray-500 border-gray-200',
                        'completed' => 'bg-blue-50 text-blue-700 border-blue-200',
                    ][$appt->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';
                @endphp
                <tr class="border-b border-gray-50 last:border-0 transition-colors duration-150"
                    style="background:white"
                    onmouseenter="this.style.background='#fdf6f9'"
                    onmouseleave="this.style.background='white'">

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                 style="background:linear-gradient(135deg,#b5708a,#d4a0b8)">
                                {{ strtoupper(substr($appt->customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $appt->customer->name }}</div>
                                <div class="text-xs text-gray-400">{{ $appt->customer->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $appt->service->name }}</td>

                    <td class="px-6 py-4 text-gray-500">{{ $appt->staff->user->name }}</td>

                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-700">{{ $appt->starts_at->format('M j, Y') }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">
                            {{ $appt->starts_at->format('g:i A') }} &ndash; {{ $appt->ends_at->format('g:i A') }}
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full border capitalize {{ $badge }}">
                            {{ $appt->status }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.appointments.status', $appt) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-medium border rounded-lg px-3 py-1.5 bg-white cursor-pointer appearance-none pr-7 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                    style="border-color:#e5e7eb; color:#374151; background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E\"); background-repeat:no-repeat; background-position:right 8px center; --tw-ring-color:#b5708a">
                                @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $appt->status === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4" style="border-top:1px solid #f5f4f4">
            {{ $appointments->links() }}
        </div>
    @endif
</div>

</x-admin-layout>
