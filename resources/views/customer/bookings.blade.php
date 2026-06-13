<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Bookings</h1>
            <p class="text-gray-500 text-sm mt-1">All your upcoming and past appointments.</p>
        </div>
        <a href="{{ route('book') }}"
           class="text-white text-sm font-medium px-5 py-2.5 rounded-xl transition shadow"
           style="background:#b5708a">+ New Booking</a>
    </div>

    @if($appointments->isEmpty())
        <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
            <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background:rgba(181,112,138,0.1)">
                <svg class="w-7 h-7" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-1">No appointments yet</h3>
            <p class="text-gray-400 text-sm mb-6">Book your first appointment to get started.</p>
            <a href="{{ route('book') }}"
               class="inline-block text-white font-medium px-6 py-2.5 rounded-xl text-sm"
               style="background:#b5708a">Book Now</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($appointments as $appointment)
            @php
                $statusColors = [
                    'pending'   => 'bg-yellow-100 text-yellow-800',
                    'confirmed' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-gray-100 text-gray-500',
                    'completed' => 'bg-blue-100 text-blue-700',
                ];
                $color = $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-600';
                $isPast = $appointment->starts_at->isPast();
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                        {{ $appointment->status === 'cancelled' ? 'opacity-60' : '' }}">
                <div class="flex items-center justify-between p-6">
                    <div class="flex items-start gap-5">
                        {{-- Date block --}}
                        <div class="text-center shrink-0 w-14">
                            <div class="text-xs font-semibold text-gray-400 uppercase">
                                {{ $appointment->starts_at->format('M') }}
                            </div>
                            <div class="text-3xl font-bold text-gray-900 leading-none">
                                {{ $appointment->starts_at->format('j') }}
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $appointment->starts_at->format('Y') }}
                            </div>
                        </div>

                        <div class="border-l border-gray-100 pl-5">
                            <h3 class="font-semibold text-gray-800">{{ $appointment->service->name }}</h3>
                            <div class="text-sm text-gray-500 mt-1 space-y-0.5">
                                <div>
                                    {{ $appointment->starts_at->format('g:i A') }} &ndash;
                                    {{ $appointment->ends_at->format('g:i A') }}
                                </div>
                                <div>with {{ $appointment->staff->user->name }}</div>
                                @if($appointment->notes)
                                    <div class="text-gray-400 text-xs mt-1 italic">"{{ $appointment->notes }}"</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-3 shrink-0">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full capitalize {{ $color }}">
                            {{ $appointment->status }}
                        </span>

                        @if(in_array($appointment->status, ['pending', 'confirmed']) && !$isPast)
                            <form method="POST" action="{{ route('appointments.cancel', $appointment) }}"
                                  onsubmit="return confirm('Cancel this appointment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 underline underline-offset-2">
                                    Cancel
                                </button>
                            </form>
                        @endif

                        @if($isPast || $appointment->status === 'completed')
                            <a href="{{ route('book', ['service_id' => $appointment->service_id, 'staff_id' => $appointment->staff_id]) }}"
                               class="text-xs font-medium px-3 py-1.5 rounded-lg border transition"
                               style="color:#b5708a; border-color:#e8c4d4; background:rgba(181,112,138,0.06)"
                               onmouseenter="this.style.background='rgba(181,112,138,0.12)'"
                               onmouseleave="this.style.background='rgba(181,112,138,0.06)'">
                                ↻ Book again
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
</x-app-layout>
