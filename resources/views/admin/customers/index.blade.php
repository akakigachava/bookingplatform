<x-admin-layout>
<x-slot name="title">Customers</x-slot>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Customers</h2>
        <p class="text-sm text-gray-400 mt-0.5">All registered customers and their booking history.</p>
    </div>
    <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-white border border-gray-200 text-gray-500 shadow-sm">
        {{ $customers->count() }} {{ Str::plural('customer', $customers->count()) }}
    </span>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
     style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

    @if($customers->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                 style="background:rgba(181,112,138,0.1)">
                <svg class="w-7 h-7" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800">No customers yet</p>
            <p class="text-xs text-gray-400 mt-1">Customers will appear here once they register.</p>
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#fafafa; border-bottom:1px solid #f0eff0">
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Bookings</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Last Appointment</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                @php
                    $lastAppt = $customer->appointments->first();
                    $isWalkin = str_contains($customer->email, '@bookease.local');
                @endphp
                <tr class="border-b border-gray-50 last:border-0 transition-colors duration-150"
                    style="background:white"
                    onmouseenter="this.style.background='#fdf6f9'"
                    onmouseleave="this.style.background='white'">

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0"
                                 style="background:linear-gradient(135deg,#b5708a,#d4a0b8)">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $customer->name }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $isWalkin ? 'No email provided' : $customer->email }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-gray-500 text-sm">
                        {{ $customer->created_at->format('M j, Y') }}
                    </td>

                    <td class="px-6 py-4">
                        @if($customer->appointments_count > 0)
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold text-white"
                                  style="background:#b5708a">
                                {{ $customer->appointments_count }}
                            </span>
                        @else
                            <span class="text-xs text-gray-300">None</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-500">
                        @if($lastAppt)
                            <div class="font-medium text-gray-700">{{ $lastAppt->starts_at->format('M j, Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $lastAppt->starts_at->format('g:i A') }}</div>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        @if($isWalkin)
                            <span class="inline-flex text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                Walk-in
                            </span>
                        @else
                            <span class="inline-flex text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                Registered
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-3" style="border-top:1px solid #f5f4f4; background:#fafafa">
            <p class="text-xs text-gray-400">{{ $customers->count() }} {{ Str::plural('customer', $customers->count()) }} total</p>
        </div>
    @endif
</div>

</x-admin-layout>
