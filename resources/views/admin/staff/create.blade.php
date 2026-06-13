<x-admin-layout>
<x-slot name="title">Add Staff</x-slot>

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
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
         style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

        <div class="px-6 py-4" style="border-bottom:1px solid #f5f4f4">
            <h2 class="text-sm font-semibold text-gray-800">New Staff Member</h2>
            <p class="text-xs text-gray-400 mt-0.5">They'll be able to log in and view appointments.</p>
        </div>

        <form method="POST" action="{{ route('admin.staff.store') }}" class="px-6 py-6 space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Full Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. Sarah Johnson"
                       class="w-full border rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition
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
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="e.g. sarah@bookease.com"
                       class="w-full border rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition
                              {{ $errors->has('email') ? 'border-red-300' : 'border-gray-200' }}"
                       style="--tw-ring-color:#b5708a">
                @error('email')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Password <span class="text-red-400">*</span>
                </label>
                <input type="password" name="password" required
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
                          placeholder="e.g. Senior stylist with 8 years of experience in colour and highlights."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 resize-none focus:outline-none focus:ring-2 focus:border-transparent transition"
                          style="--tw-ring-color:#b5708a">{{ old('bio') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Shown on the public booking page.</p>
            </div>

            {{-- Active toggle --}}
            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-xl border border-gray-100">
                <div>
                    <div class="text-sm font-medium text-gray-700">Active</div>
                    <div class="text-xs text-gray-400 mt-0.5">Inactive staff won't appear on the booking form.</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Staff Member
                </button>
                <a href="{{ route('admin.staff.index') }}"
                   class="text-sm font-medium text-gray-400 hover:text-gray-600 px-4 py-2.5 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

</x-admin-layout>
