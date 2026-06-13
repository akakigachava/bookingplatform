<x-admin-layout>
<x-slot name="title">Business Hours</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Business Hours</h2>
        <p class="text-sm text-gray-400 mt-0.5">Set the days and times customers can book appointments.</p>
    </div>
</div>

{{-- Full-width card --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
     style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

    {{-- Card header --}}
    <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #f5f4f4">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(181,112,138,0.1)">
                <svg class="w-4 h-4" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-gray-800">Weekly Schedule</span>
        </div>
        <span class="text-xs text-gray-400">Toggle days open or closed</span>
    </div>

    <form method="POST" action="{{ route('admin.business-hours.update') }}">
        @csrf

        @php
            $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            $dayAbbr  = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        @endphp

        {{-- Column headers --}}
        <div class="grid items-center gap-4 px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400"
             style="grid-template-columns: 1fr 1fr 1fr auto; border-bottom:1px solid #f5f4f4; background:#fafafa">
            <div>Day</div>
            <div>Opens</div>
            <div>Closes</div>
            <div class="text-center w-16">Open</div>
        </div>

        {{-- Day rows --}}
        @foreach(range(0,6) as $day)
        @php $h = $hours->get($day); $isOpen = $h && $h->is_open; @endphp

        <div class="grid items-center gap-4 px-6 py-4 transition-colors duration-150
                    {{ $day < 6 ? '' : '' }}"
             style="grid-template-columns: 1fr 1fr 1fr auto;
                    border-bottom: {{ $day < 6 ? '1px solid #f5f4f4' : 'none' }};
                    background: {{ $isOpen ? 'white' : '#fafafa' }}">

            {{-- Day name --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold shrink-0"
                     style="{{ $isOpen
                         ? 'background:rgba(181,112,138,0.12); color:#b5708a;'
                         : 'background:#f3f3f3; color:#aaa;' }}">
                    {{ $dayAbbr[$day] }}
                </div>
                <div>
                    <div class="text-sm font-semibold {{ $isOpen ? 'text-gray-800' : 'text-gray-400' }}">
                        {{ $dayNames[$day] }}
                    </div>
                    @if(!$isOpen)
                        <div class="text-xs text-gray-400">Closed</div>
                    @endif
                </div>
            </div>

            {{-- Open time --}}
            <input type="time" name="days[{{ $day }}][open_time]"
                   value="{{ $h ? $h->open_time : '09:00' }}"
                   class="border rounded-xl px-3 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:border-transparent transition w-full max-w-[130px]
                          {{ $isOpen ? 'border-gray-200' : 'border-gray-100 text-gray-300' }}"
                   style="--tw-ring-color:#b5708a">

            {{-- Close time --}}
            <input type="time" name="days[{{ $day }}][close_time]"
                   value="{{ $h ? $h->close_time : '18:00' }}"
                   class="border rounded-xl px-3 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:border-transparent transition w-full max-w-[130px]
                          {{ $isOpen ? 'border-gray-200' : 'border-gray-100 text-gray-300' }}"
                   style="--tw-ring-color:#b5708a">

            {{-- Toggle switch --}}
            <div class="flex justify-center w-16">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox"
                           name="days[{{ $day }}]"
                           value="1"
                           {{ $isOpen ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-10 h-6 rounded-full transition-colors duration-200 ease-in-out
                                bg-gray-200 peer-checked:bg-[#b5708a]
                                after:content-[''] after:absolute after:top-[3px] after:left-[3px]
                                after:bg-white after:rounded-full after:h-[18px] after:w-[18px]
                                after:shadow-sm after:transition-all after:duration-200
                                peer-checked:after:translate-x-4
                                relative">
                    </div>
                </label>
            </div>

        </div>
        @endforeach

        {{-- Save button --}}
        <div class="px-6 py-5 flex items-center gap-3" style="border-top:1px solid #f5f4f4; background:#fafafa">
            <button type="submit"
                    class="inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
                    style="background:#b5708a">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
                Save Business Hours
            </button>
            <span class="text-xs text-gray-400">Changes apply immediately to new bookings.</span>
        </div>
    </form>
</div>

</x-admin-layout>
