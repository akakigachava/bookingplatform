<x-admin-layout>
<x-slot name="title">My Schedule</x-slot>

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">My Schedule</h2>
        <p class="text-sm text-gray-400 mt-0.5">{{ today()->format('l, F j, Y') }}</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold shrink-0"
             style="background:linear-gradient(135deg,#b5708a,#d4a0b8)">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <div class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</div>
            <div class="text-xs text-gray-400">Staff Member</div>
        </div>
    </div>
</div>

{{-- Today --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-5"
     style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

    <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #f5f4f4">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full" style="background:#b5708a"></div>
            <h3 class="text-sm font-semibold text-gray-800">Today</h3>
        </div>
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full border"
              style="background:rgba(181,112,138,0.08); color:#b5708a; border-color:#e8c4d4">
            {{ $today->count() }} {{ Str::plural('appointment', $today->count()) }}
        </span>
    </div>

    @if($today->isEmpty())
        <div class="text-center py-12">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3"
                 style="background:rgba(181,112,138,0.08)">
                <svg class="w-6 h-6" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-600">All clear today!</p>
            <p class="text-xs text-gray-400 mt-1">No appointments scheduled.</p>
        </div>
    @else
        <div class="divide-y divide-gray-50">
            @foreach($today as $appt)
            @php
                $isPast = $appt->starts_at->isPast();
                $badge = [
                    'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                    'confirmed' => 'bg-green-50 text-green-700 border-green-200',
                    'cancelled' => 'bg-gray-100 text-gray-500 border-gray-200',
                    'completed' => 'bg-blue-50 text-blue-700 border-blue-200',
                ][$appt->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';
            @endphp
            <div class="flex items-center gap-5 px-6 py-4 {{ $isPast && $appt->status !== 'completed' ? 'opacity-60' : '' }}"
                 style="background: {{ $appt->status === 'completed' ? '#f9fefb' : 'white' }}">

                {{-- Time block --}}
                <div class="text-center shrink-0 w-14">
                    <div class="text-base font-bold text-gray-900">{{ $appt->starts_at->format('g:i') }}</div>
                    <div class="text-xs text-gray-400">{{ $appt->starts_at->format('A') }}</div>
                    <div class="text-xs text-gray-300 mt-0.5">{{ $appt->service->duration_minutes }}m</div>
                </div>

                {{-- Divider --}}
                <div class="w-px self-stretch" style="background:#f0eff0"></div>

                {{-- Details --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                             style="background:linear-gradient(135deg,#b5708a,#d4a0b8)">
                            {{ strtoupper(substr($appt->customer->name, 0, 1)) }}
                        </div>
                        <div class="font-semibold text-gray-800 text-sm truncate">{{ $appt->customer->name }}</div>
                    </div>
                    <div class="text-xs text-gray-500 mt-1.5 flex items-center gap-3">
                        <span>{{ $appt->service->name }}</span>
                        <span class="text-gray-200">·</span>
                        <span>{{ $appt->starts_at->format('g:i A') }} – {{ $appt->ends_at->format('g:i A') }}</span>
                        @if($appt->notes)
                            <span class="text-gray-200">·</span>
                            <span class="italic text-gray-400 truncate max-w-xs">"{{ $appt->notes }}"</span>
                        @endif
                    </div>
                </div>

                {{-- Status + action --}}
                <div class="flex items-center gap-2 shrink-0">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full border capitalize {{ $badge }}">
                        {{ $appt->status }}
                    </span>
                    @if(in_array($appt->status, ['pending', 'confirmed']) && $isPast)
                        <form method="POST" action="{{ route('admin.appointments.status', $appt) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit"
                                    class="text-xs font-semibold text-green-600 border border-green-200 px-3 py-1.5 rounded-lg bg-white hover:bg-green-50 transition-colors">
                                ✓ Mark Done
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Upcoming this week --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
     style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

    <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #f5f4f4">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
            <h3 class="text-sm font-semibold text-gray-800">Upcoming — Next 7 Days</h3>
        </div>
        <span class="text-xs text-gray-400">{{ $upcoming->count() }} {{ Str::plural('appointment', $upcoming->count()) }}</span>
    </div>

    @if($upcoming->isEmpty())
        <div class="text-center py-10 text-sm text-gray-400">Nothing scheduled for the next 7 days.</div>
    @else
        @php $grouped = $upcoming->groupBy(fn($a) => $a->starts_at->toDateString()); @endphp
        @foreach($grouped as $date => $appts)
        <div>
            <div class="px-6 py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-widest"
                 style="background:#fafafa; border-bottom:1px solid #f5f4f4">
                {{ \Carbon\Carbon::parse($date)->format('l, M j') }}
            </div>
            @foreach($appts as $appt)
            <div class="flex items-center gap-5 px-6 py-3.5 border-b border-gray-50 last:border-0">

                <div class="text-center shrink-0 w-14">
                    <div class="text-sm font-bold text-gray-900">{{ $appt->starts_at->format('g:i') }}</div>
                    <div class="text-xs text-gray-400">{{ $appt->starts_at->format('A') }}</div>
                </div>

                <div class="w-px h-8" style="background:#f0eff0"></div>

                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-gray-800">{{ $appt->customer->name }}</div>
                    <div class="text-xs text-gray-400 mt-0.5">{{ $appt->service->name }} · {{ $appt->service->duration_minutes }} min</div>
                </div>

                @php
                    $badge = [
                        'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                        'confirmed' => 'bg-green-50 text-green-700 border-green-200',
                    ][$appt->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';
                @endphp
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full border capitalize {{ $badge }} shrink-0">
                    {{ $appt->status }}
                </span>
            </div>
            @endforeach
        </div>
        @endforeach
    @endif
</div>

</x-admin-layout>
