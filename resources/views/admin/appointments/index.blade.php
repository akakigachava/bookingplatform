<x-admin-layout>
<x-slot name="title">Appointments</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-bold" style="font-size:22px; color:#0b1c30;">Appointments</h2>
        <p class="text-sm mt-0.5" style="color:#514348;">View and manage all customer bookings.</p>
    </div>
    <div class="flex items-center gap-3">
        @if($appointments->total() > 0)
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full"
                  style="background:#eddfe4; color:#664461;">
                {{ $appointments->total() }} {{ Str::plural('booking', $appointments->total()) }}
            </span>
        @endif
        <a href="{{ route('admin.appointments.create') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-white px-4 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
           style="background:#864461;">
            <span class="material-symbols-outlined" style="font-size:16px; font-variation-settings:'FILL' 1;">add_circle</span>
            New Booking
        </a>
    </div>
</div>

{{-- Filter card --}}
<div class="rounded-xl mb-5 overflow-hidden"
     style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
    <div class="flex items-center gap-2 px-5 py-3.5" style="border-bottom:1px solid #eff4ff; background:#f8f9ff;">
        <span class="material-symbols-outlined" style="font-size:16px; color:#847378;">filter_list</span>
        <span class="text-xs font-semibold uppercase tracking-widest" style="color:#847378;">Filter</span>
    </div>
    <form method="GET" class="px-5 py-4 flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:#514348;">Date</label>
            <input type="date" name="date" value="{{ request('date') }}"
                   class="border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                   style="border-color:#d6c1c7; color:#0b1c30; background:white; --tw-ring-color:#864461;">
        </div>

        <div>
            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:#514348;">Status</label>
            <select name="status"
                    class="border rounded-xl px-3 py-2 text-sm appearance-none pr-8 cursor-pointer focus:outline-none focus:ring-2 focus:border-transparent transition"
                    style="border-color:#d6c1c7; color:#0b1c30; background:white; --tw-ring-color:#864461;
                           background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23847378' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E\");
                           background-repeat:no-repeat; background-position:right 10px center;">
                <option value="">All Statuses</option>
                @foreach(['pending','confirmed','cancelled','completed'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-white px-4 py-2 rounded-xl transition hover:opacity-90"
                    style="background:#864461;">
                <span class="material-symbols-outlined" style="font-size:15px; font-variation-settings:'FILL' 1;">filter_alt</span>
                Apply
            </button>
            @if(request()->anyFilled(['date','status']))
                <a href="{{ route('admin.appointments.index') }}"
                   class="inline-flex items-center gap-1.5 text-sm font-medium px-4 py-2 rounded-xl border transition-colors"
                   style="color:#665c60; border-color:#d6c1c7; background:white;"
                   onmouseenter="this.style.background='#eff4ff'"
                   onmouseleave="this.style.background='white'">
                    <span class="material-symbols-outlined" style="font-size:15px;">close</span>
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Table card --}}
<div class="rounded-xl overflow-hidden"
     style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">

    @if($appointments->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <span class="material-symbols-outlined mb-3" style="font-size:48px; color:#d6c1c7;">calendar_month</span>
            <p class="text-sm font-semibold" style="color:#0b1c30;">
                {{ request()->anyFilled(['date','status']) ? 'No appointments match your filters' : 'No appointments yet' }}
            </p>
            <p class="text-xs mt-1 mb-5" style="color:#847378;">
                {{ request()->anyFilled(['date','status']) ? 'Try a different date or status.' : 'Appointments will appear here once customers start booking.' }}
            </p>
            @if(request()->anyFilled(['date','status']))
                <a href="{{ route('admin.appointments.index') }}"
                   class="text-xs font-semibold px-4 py-2 rounded-xl text-white transition hover:opacity-90"
                   style="background:#864461;">Clear Filters</a>
            @endif
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#f8f9ff; border-bottom:1px solid #eff4ff;">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Customer</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Service</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Staff</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Date &amp; Time</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Status</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appt)
                @php
                    $statusColors = [
                        'pending'   => ['bg'=>'#ffd9e5', 'text'=>'#864461'],
                        'confirmed' => ['bg'=>'#bcedda', 'text'=>'#204f41'],
                        'cancelled' => ['bg'=>'#dce9ff', 'text'=>'#514348'],
                        'completed' => ['bg'=>'#e5eeff', 'text'=>'#3a0522'],
                    ][$appt->status] ?? ['bg'=>'#dce9ff', 'text'=>'#514348'];
                @endphp
                <tr style="border-bottom:1px solid #eff4ff; background:white;"
                    onmouseenter="this.style.background='#f8f9ff'"
                    onmouseleave="this.style.background='white'">

                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                 style="background:#864461;">
                                {{ strtoupper(substr($appt->customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold" style="color:#0b1c30;">{{ $appt->customer->name }}</div>
                                <div class="text-xs mt-0.5" style="color:#847378;">{{ $appt->customer->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-5 py-4 font-medium" style="color:#514348;">{{ $appt->service->name }}</td>

                    <td class="px-5 py-4" style="color:#665c60;">{{ $appt->staff->user->name }}</td>

                    <td class="px-5 py-4">
                        <div class="font-medium" style="color:#0b1c30;">{{ $appt->starts_at->format('M j, Y') }}</div>
                        <div class="text-xs mt-0.5" style="color:#847378;">
                            {{ $appt->starts_at->format('g:i A') }} – {{ $appt->ends_at->format('g:i A') }}
                        </div>
                    </td>

                    <td class="px-5 py-4">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full capitalize"
                              style="background:{{ $statusColors['bg'] }}; color:{{ $statusColors['text'] }};">
                            {{ $appt->status }}
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.appointments.status', $appt) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-medium rounded-xl px-3 py-1.5 border cursor-pointer appearance-none pr-7 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                    style="border-color:#d6c1c7; color:#514348; background:white; --tw-ring-color:#864461;
                                           background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23847378' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E\");
                                           background-repeat:no-repeat; background-position:right 7px center;">
                                @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $appt->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-5 py-4" style="border-top:1px solid #eff4ff;">
            {{ $appointments->links() }}
        </div>
    @endif
</div>

</x-admin-layout>
