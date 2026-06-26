<x-admin-layout>
<x-slot name="title">Business Hours</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-bold" style="font-size:22px; color:#0b1c30;">Business Hours Configuration</h2>
        <p class="text-sm mt-0.5" style="color:#514348;">Set your weekly operating times. Clients can only book within these hours.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.business-hours.update') }}">
    @csrf

    @php
        $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $dayAbbr  = ['Su','Mo','Tu','We','Th','Fr','Sa'];
    @endphp

    <div class="space-y-3 mb-6">
        @foreach(range(0,6) as $day)
        @php $h = $hours->get($day); $isOpen = $h && $h->is_open; @endphp

        <div class="flex flex-col md:flex-row md:items-center gap-4 px-5 py-4 rounded-xl transition-all"
             style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.03);"
             id="day-row-{{ $day }}">

            {{-- Day avatar + name --}}
            <div class="flex items-center gap-4 md:w-1/4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-sm font-bold shrink-0"
                     style="{{ $isOpen
                         ? 'background:#eddfe4; color:#864461;'
                         : 'background:#f0eef0; color:#b0a8ac;' }}">
                    {{ $dayAbbr[$day] }}
                </div>
                <div>
                    <div class="font-semibold" style="font-size:15px; color:{{ $isOpen ? '#0b1c30' : '#b0a8ac' }};">
                        {{ $dayNames[$day] }}
                    </div>
                    @if(!$isOpen)
                        <div class="text-xs mt-0.5" style="color:#ba1a1a;">Closed</div>
                    @else
                        <div class="text-xs mt-0.5" style="color:#356253;">Open</div>
                    @endif
                </div>
            </div>

            {{-- Times + toggle --}}
            <div class="flex flex-wrap items-center gap-5 md:flex-1">

                {{-- Toggle --}}
                <div class="flex items-center gap-3 px-3 py-1 rounded-full" style="background:#f8f9ff; border:1px solid #d6c1c7;">
                    <span class="text-xs font-semibold uppercase tracking-wider"
                          style="color:{{ $isOpen ? '#356253' : '#ba1a1a' }};">
                        {{ $isOpen ? 'Open' : 'Closed' }}
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="days[{{ $day }}]"
                               value="1"
                               {{ $isOpen ? 'checked' : '' }}
                               class="sr-only peer"
                               onchange="updateDayRow({{ $day }}, this.checked)">
                        <div class="w-11 h-6 rounded-full relative transition-colors duration-200"
                             style="background:{{ $isOpen ? '#864461' : '#d6c1c7' }};"
                             id="toggle-bg-{{ $day }}">
                            <div class="absolute top-0.5 w-5 h-5 rounded-full bg-white shadow-sm transition-all duration-200"
                                 style="left:{{ $isOpen ? 'calc(100% - 22px)' : '2px' }};"
                                 id="toggle-dot-{{ $day }}"></div>
                        </div>
                    </label>
                </div>

                {{-- Time inputs --}}
                <div class="flex items-center gap-2">
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold mb-1 uppercase tracking-wider" style="color:#847378;">Opens</span>
                        <input type="time" name="days[{{ $day }}][open_time]"
                               value="{{ $h ? $h->open_time : '09:00' }}"
                               class="border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                               style="border-color:#d6c1c7; color:{{ $isOpen ? '#0b1c30' : '#c0babb' }}; background:{{ $isOpen ? 'white' : '#fafafa' }}; --tw-ring-color:#864461;">
                    </div>
                    <span class="mt-5 font-medium" style="color:#847378;">–</span>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold mb-1 uppercase tracking-wider" style="color:#847378;">Closes</span>
                        <input type="time" name="days[{{ $day }}][close_time]"
                               value="{{ $h ? $h->close_time : '18:00' }}"
                               class="border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                               style="border-color:#d6c1c7; color:{{ $isOpen ? '#0b1c30' : '#c0babb' }}; background:{{ $isOpen ? 'white' : '#fafafa' }}; --tw-ring-color:#864461;">
                    </div>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    {{-- Save footer --}}
    <div class="sticky bottom-4 flex justify-end gap-3 px-5 py-4 rounded-2xl backdrop-blur-sm"
         style="background:rgba(248,249,255,0.85); border:1px solid #d3e4fe; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
        <a href="{{ route('admin.business-hours.index') }}"
           class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors"
           style="color:#864461;"
           onmouseenter="this.style.background='#eddfe4'"
           onmouseleave="this.style.background=''">
            Discard Changes
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white shadow-md transition hover:opacity-90 active:scale-95"
                style="background:#864461;">
            <span class="material-symbols-outlined" style="font-size:16px; font-variation-settings:'FILL' 1;">save</span>
            Save Business Hours
        </button>
    </div>
</form>

<script>
function updateDayRow(day, isOpen) {
    const row    = document.getElementById('day-row-' + day);
    const bg     = document.getElementById('toggle-bg-' + day);
    const dot    = document.getElementById('toggle-dot-' + day);
    const avatar = row.querySelector('.w-12');
    const name   = row.querySelector('.font-semibold');
    const label  = row.querySelector('.text-xs.mt-0\\.5');
    const inputs = row.querySelectorAll('input[type="time"]');
    const status = row.querySelector('.text-xs.font-semibold.uppercase');

    bg.style.background  = isOpen ? '#864461' : '#d6c1c7';
    dot.style.left       = isOpen ? 'calc(100% - 22px)' : '2px';
    avatar.style.background = isOpen ? '#eddfe4' : '#f0eef0';
    avatar.style.color      = isOpen ? '#864461' : '#b0a8ac';
    name.style.color        = isOpen ? '#0b1c30' : '#b0a8ac';
    label.textContent       = isOpen ? 'Open' : 'Closed';
    label.style.color       = isOpen ? '#356253' : '#ba1a1a';
    status.textContent      = isOpen ? 'Open' : 'Closed';
    status.style.color      = isOpen ? '#356253' : '#ba1a1a';
    inputs.forEach(input => {
        input.style.color      = isOpen ? '#0b1c30' : '#c0babb';
        input.style.background = isOpen ? 'white' : '#fafafa';
    });
}
</script>
</x-admin-layout>
