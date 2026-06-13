<x-admin-layout>
<x-slot name="title">Staff</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Staff Members</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage the team that handles bookings.</p>
    </div>
    <a href="{{ route('admin.staff.create') }}"
       class="inline-flex items-center gap-1.5 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
       style="background:#b5708a">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Add Staff
    </a>
</div>

{{-- Table card --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
     style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

    @if($staff->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                 style="background:rgba(181,112,138,0.1)">
                <svg class="w-7 h-7" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800">No staff members yet</p>
            <p class="text-xs text-gray-400 mt-1 mb-5">Add your first team member to start accepting bookings.</p>
            <a href="{{ route('admin.staff.create') }}"
               class="text-white text-xs font-semibold px-4 py-2 rounded-lg transition hover:opacity-90"
               style="background:#b5708a">Add Staff Member</a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#fafafa; border-bottom:1px solid #f0eff0">
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bio</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bookings</th>
                    <th class="px-6 py-3.5"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($staff as $member)
                <tr class="border-b border-gray-50 last:border-0 transition-colors duration-150"
                    style="background:white"
                    onmouseenter="this.style.background='#fdf6f9'"
                    onmouseleave="this.style.background='white'">

                    {{-- Avatar + Name --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0"
                                 style="background:linear-gradient(135deg,#b5708a,#d4a0b8)">
                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                            </div>
                            <div class="font-semibold text-gray-800">{{ $member->user->name }}</div>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4 text-gray-500">{{ $member->user->email }}</td>

                    {{-- Bio --}}
                    <td class="px-6 py-4 text-gray-500 max-w-xs">
                        @if($member->bio)
                            <span class="line-clamp-1">{{ $member->bio }}</span>
                        @else
                            <span class="text-gray-300 italic">No bio</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4">
                        @if($member->is_active)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Inactive
                            </span>
                        @endif
                    </td>

                    {{-- Booking count --}}
                    <td class="px-6 py-4">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $member->appointments()->count() }}
                        </span>
                        <span class="text-xs text-gray-400 ml-1">total</span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.staff.edit', $member) }}"
                               class="inline-flex items-center gap-1 text-xs font-medium text-gray-600 border border-gray-200 px-3 py-1.5 rounded-lg bg-white hover:border-gray-300 hover:text-gray-800 transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $member) }}"
                                  onsubmit="return confirm('Remove {{ addslashes($member->user->name) }} from the team? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-red-500 border border-red-200 px-3 py-1.5 rounded-lg bg-white hover:bg-red-50 hover:border-red-300 hover:text-red-700 transition-colors duration-150">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-3" style="border-top:1px solid #f5f4f4; background:#fafafa">
            <p class="text-xs text-gray-400">
                {{ $staff->count() }} {{ Str::plural('member', $staff->count()) }} total
            </p>
        </div>
    @endif
</div>

</x-admin-layout>
