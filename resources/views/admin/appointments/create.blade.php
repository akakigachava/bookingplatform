<x-admin-layout>
<x-slot name="title">New Booking</x-slot>

<div class="mb-6">
    <a href="{{ route('admin.appointments.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Appointments
    </a>
</div>

<div class="max-w-2xl">

    @if(session('error'))
        <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
            <svg class="w-4 h-4 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.appointments.store') }}" class="space-y-4">
        @csrf

        {{-- Customer --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
             style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.05)">
            <div class="px-6 py-4" style="border-bottom:1px solid #f5f4f4">
                <h3 class="text-sm font-semibold text-gray-800">Customer</h3>
            </div>
            <div class="px-6 py-4 space-y-4">

                {{-- Toggle --}}
                <div class="flex rounded-xl border border-gray-200 overflow-hidden text-sm font-medium">
                    <button type="button" id="tab-existing"
                            onclick="switchTab('existing')"
                            class="flex-1 py-2 text-center transition-colors tab-active">
                        Existing Customer
                    </button>
                    <button type="button" id="tab-walkin"
                            onclick="switchTab('walkin')"
                            class="flex-1 py-2 text-center transition-colors tab-inactive" style="border-left:1px solid #e5e7eb">
                        Walk-in / New
                    </button>
                </div>

                {{-- Existing customer dropdown --}}
                <div id="panel-existing">
                    <select name="customer_id" id="customer_id"
                            class="w-full border rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:border-transparent transition
                                   {{ $errors->has('customer_id') ? 'border-red-300' : 'border-gray-200' }}"
                            style="--tw-ring-color:#b5708a">
                        <option value="">— Select customer —</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Walk-in fields --}}
                <div id="panel-walkin" class="hidden space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Full Name <span class="text-red-400">*</span></label>
                        <input type="text" name="walkin_name" value="{{ old('walkin_name') }}"
                               placeholder="e.g. John Smith"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                               style="--tw-ring-color:#b5708a">
                        @error('walkin_name')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Email <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="email" name="walkin_email" value="{{ old('walkin_email') }}"
                               placeholder="e.g. john@example.com"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                               style="--tw-ring-color:#b5708a">
                        @error('walkin_email')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">A guest account will be created so they can log in later.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Service --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
             style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.05)">
            <div class="px-6 py-4" style="border-bottom:1px solid #f5f4f4">
                <h3 class="text-sm font-semibold text-gray-800">Service</h3>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($services as $service)
                    <label class="cursor-pointer">
                        <input type="radio" name="service_id" value="{{ $service->id }}"
                               {{ old('service_id') == $service->id ? 'checked' : '' }}
                               class="sr-only peer" onchange="resetSlots()">
                        <div class="border-2 rounded-xl p-4 transition flex justify-between items-start
                                    border-gray-200 peer-checked:border-[#b5708a] peer-checked:bg-[#b5708a]/5
                                    hover:border-[#b5708a]/50">
                            <div>
                                <div class="font-medium text-gray-800 text-sm">{{ $service->name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $service->duration_minutes }} min</div>
                            </div>
                            <div class="font-bold text-gray-900 text-sm">R{{ number_format($service->price, 2) }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('service_id')
                    <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Staff --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
             style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.05)">
            <div class="px-6 py-4" style="border-bottom:1px solid #f5f4f4">
                <h3 class="text-sm font-semibold text-gray-800">Staff Member</h3>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($staff as $member)
                    <label class="cursor-pointer">
                        <input type="radio" name="staff_id" value="{{ $member->id }}"
                               {{ old('staff_id') == $member->id ? 'checked' : '' }}
                               class="sr-only peer" onchange="resetSlots()">
                        <div class="border-2 rounded-xl p-3 text-center transition
                                    border-gray-200 peer-checked:border-[#b5708a] peer-checked:bg-[#b5708a]/5
                                    hover:border-[#b5708a]/50">
                            <div class="w-12 h-12 rounded-full mx-auto mb-2 flex items-center justify-center text-white font-bold text-lg"
                                 style="background: linear-gradient(135deg, #b5708a, #d4a0b8)">
                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                            </div>
                            <div class="text-xs font-medium text-gray-700">{{ $member->user->name }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('staff_id')
                    <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Date & Time --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
             style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.05)">
            <div class="px-6 py-4" style="border-bottom:1px solid #f5f4f4">
                <h3 class="text-sm font-semibold text-gray-800">Date &amp; Time</h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Date</label>
                    <input type="date" name="date" id="booking-date"
                           value="{{ old('date') }}"
                           min="{{ date('Y-m-d') }}"
                           onchange="loadSlots()"
                           class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:border-transparent transition"
                           style="--tw-ring-color:#b5708a">
                    @error('date')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Available Slots</label>
                    <input type="hidden" name="time" id="selected-time" value="{{ old('time') }}">
                    <div id="slots-container">
                        <p class="text-xs text-gray-400 italic">Select a service, staff member, and date first.</p>
                    </div>
                    @error('time')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
             style="box-shadow:0 1px 4px 0 rgba(0,0,0,0.05)">
            <div class="px-6 py-4" style="border-bottom:1px solid #f5f4f4">
                <h3 class="text-sm font-semibold text-gray-800">Notes <span class="font-normal text-gray-400">(optional)</span></h3>
            </div>
            <div class="px-6 py-4">
                <textarea name="notes" rows="2" maxlength="500"
                          placeholder="Any special requests or notes for this appointment..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 resize-none focus:outline-none focus:ring-2 focus:border-transparent transition"
                          style="--tw-ring-color:#b5708a">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-1">
            <button type="submit"
                    class="inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
                    style="background:#b5708a">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Confirm Booking
            </button>
            <a href="{{ route('admin.appointments.index') }}"
               class="text-sm font-medium text-gray-400 hover:text-gray-600 px-4 py-2.5 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
.slot-btn { transition: all 0.15s ease; }
.slot-btn.selected { background: #b5708a; color: white; border-color: #b5708a; }
.tab-active   { background: #b5708a; color: white; }
.tab-inactive { background: white; color: #6b7280; }
</style>

<script>
function getServiceId() {
    const r = document.querySelector('input[name="service_id"]:checked');
    return r ? r.value : null;
}
function getStaffId() {
    const r = document.querySelector('input[name="staff_id"]:checked');
    return r ? r.value : null;
}
function resetSlots() {
    document.getElementById('selected-time').value = '';
    loadSlots();
}
function loadSlots() {
    const serviceId = getServiceId();
    const staffId   = getStaffId();
    const date      = document.getElementById('booking-date').value;
    const container = document.getElementById('slots-container');

    if (!serviceId || !staffId || !date) {
        container.innerHTML = '<p class="text-xs text-gray-400 italic">Select a service, staff member, and date first.</p>';
        return;
    }

    container.innerHTML = '<p class="text-xs text-gray-400 italic">Loading slots...</p>';

    fetch(`/book/slots?service_id=${serviceId}&staff_id=${staffId}&date=${date}`)
        .then(r => r.json())
        .then(data => {
            const slots = data.slots ?? data;
            if (!slots.length) {
                container.innerHTML = '<p class="text-xs text-gray-400 italic">No available slots for this day.</p>';
                return;
            }
            const previousTime = document.getElementById('selected-time').value;
            container.innerHTML = '<div class="flex flex-wrap gap-2">' +
                slots.map(slot =>
                    `<button type="button" onclick="selectSlot(this,'${slot}')"
                             class="slot-btn text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-200 text-gray-600 hover:border-[#b5708a] hover:text-[#b5708a] ${slot === previousTime ? 'selected' : ''}">
                         ${slot}
                     </button>`
                ).join('') + '</div>';
            if (previousTime) {
                document.getElementById('selected-time').value = previousTime;
            }
        })
        .catch(() => {
            container.innerHTML = '<p class="text-xs text-red-400 italic">Could not load slots. Try again.</p>';
        });
}
function selectSlot(btn, time) {
    document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    document.getElementById('selected-time').value = time;
}

// Auto-load if date already filled (e.g. after validation error)
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('booking-date').value) loadSlots();
    // Restore tab if walk-in fields had errors
    if ('{{ old('walkin_name') }}' || '{{ old('walkin_email') }}') switchTab('walkin');
});

function switchTab(tab) {
    const isExisting = tab === 'existing';
    document.getElementById('panel-existing').classList.toggle('hidden', !isExisting);
    document.getElementById('panel-walkin').classList.toggle('hidden', isExisting);
    document.getElementById('tab-existing').className = 'flex-1 py-2 text-center transition-colors ' + (isExisting ? 'tab-active' : 'tab-inactive');
    document.getElementById('tab-walkin').className   = 'flex-1 py-2 text-center transition-colors ' + (!isExisting ? 'tab-active' : 'tab-inactive');
    // Clear the other panel's required-ness
    document.getElementById('customer_id').required = isExisting;
}
</script>

</x-admin-layout>
