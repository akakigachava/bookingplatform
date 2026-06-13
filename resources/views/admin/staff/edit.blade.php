<x-admin-layout>
<x-slot name="title">Edit Staff</x-slot>

<div class="mb-6">
    <a href="{{ route('admin.staff.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Staff
    </a>
</div>

<div class="max-w-xl">

    {{-- Profile card --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-4"
         style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

        <div class="px-6 py-4 flex items-center gap-4" style="border-bottom:1px solid #f5f4f4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0"
                 style="background:linear-gradient(135deg,#b5708a,#d4a0b8)">
                {{ strtoupper(substr($staff->user->name, 0, 1)) }}
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-800">{{ $staff->user->name }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $staff->user->email }}</div>
            </div>
            <div class="ml-auto">
                @if($staff->is_active)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Active
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Inactive
                    </span>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.staff.update', $staff) }}" class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Full Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $staff->user->name) }}" required
                       class="w-full border rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:border-transparent transition
                              {{ $errors->has('name') ? 'border-red-300' : 'border-gray-200' }}"
                       style="--tw-ring-color:#b5708a">
                @error('name')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Email Address <span class="text-red-400">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $staff->user->email) }}" required
                       class="w-full border rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:border-transparent transition
                              {{ $errors->has('email') ? 'border-red-300' : 'border-gray-200' }}"
                       style="--tw-ring-color:#b5708a">
                @error('email')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    New Password
                    <span class="text-gray-400 font-normal">(leave blank to keep current)</span>
                </label>
                <input type="password" name="password"
                       placeholder="Minimum 8 characters"
                       class="w-full border rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition
                              {{ $errors->has('password') ? 'border-red-300' : 'border-gray-200' }}"
                       style="--tw-ring-color:#b5708a">
                @error('password')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Bio
                    <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <textarea name="bio" rows="3" maxlength="500"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 resize-none focus:outline-none focus:ring-2 focus:border-transparent transition"
                          style="--tw-ring-color:#b5708a">{{ old('bio', $staff->bio) }}</textarea>
            </div>

            {{-- Active toggle --}}
            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-xl border border-gray-100">
                <div>
                    <div class="text-sm font-medium text-gray-700">Active</div>
                    <div class="text-xs text-gray-400 mt-0.5">Inactive staff won't appear on the booking form.</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $staff->is_active) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-10 h-6 rounded-full transition-colors duration-200
                                bg-gray-200 peer-checked:bg-[#b5708a]
                                after:content-[''] after:absolute after:top-[3px] after:left-[3px]
                                after:bg-white after:rounded-full after:h-[18px] after:w-[18px]
                                after:shadow-sm after:transition-all after:duration-200
                                peer-checked:after:translate-x-4 relative">
                    </div>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2" style="border-top:1px solid #f5f4f4; padding-top:1.25rem; margin-top:1.25rem">
                <button type="submit"
                        class="inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
                        style="background:#b5708a">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.staff.index') }}"
                   class="text-sm font-medium text-gray-400 hover:text-gray-600 px-4 py-2.5 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- Danger zone --}}
    <div class="bg-white rounded-2xl border border-red-100 overflow-hidden"
         style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.04)">
        <div class="px-6 py-4" style="border-bottom:1px solid #fef2f2">
            <h3 class="text-sm font-semibold text-red-600">Danger Zone</h3>
        </div>
        <div class="px-6 py-4 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-700">Remove this staff member</div>
                <div class="text-xs text-gray-400 mt-0.5">This will permanently delete their account and cannot be undone.</div>
            </div>
            <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}"
                  onsubmit="return confirm('Permanently remove {{ addslashes($staff->user->name) }}? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 border border-red-200 px-4 py-2 rounded-lg bg-white hover:bg-red-50 hover:border-red-300 hover:text-red-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Remove Member
                </button>
            </form>
        </div>
    </div>

</div>

</x-admin-layout>
