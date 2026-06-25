<x-app-layout>
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-12">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Book an Appointment</h1>
        <p class="text-gray-500 text-sm mt-1">Select a service, staff member, and time that works for you.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('book.store') }}" class="space-y-6">
        @csrf

        {{-- Service --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <label class="block text-sm font-semibold text-gray-700 mb-4">Service</label>
            @php $grouped = $services->groupBy(fn($s) => $s->category ?: 'Other'); @endphp
            <div class="space-y-5" id="service-grid">
                @foreach($grouped as $category => $categoryServices)
                    <div>
                        <div class="flex items-center gap-2 mb-2.5">
                            <span class="text-xs font-bold uppercase tracking-widest"
                                  style="color:#b5708a">{{ $category }}</span>
                            <div class="flex-1 h-px bg-gray-100"></div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($categoryServices as $service)
                            <label class="service-card cursor-pointer">
                                <input type="radio" name="service_id" value="{{ $service->id }}"
                                       {{ (old('service_id', request('service_id')) == $service->id) ? 'checked' : '' }}
                                       class="sr-only" onchange="onSelectionChange()">
                                <div class="border-2 border-gray-200 rounded-xl p-4 transition hover:border-[#b5708a] service-card-inner flex justify-between items-start">
                                    <div>
                                        <div class="font-medium text-gray-800 text-sm">{{ $service->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $service->duration_minutes }} min</div>
                                    </div>
                                    <div class="font-bold text-gray-900 text-sm">R{{ number_format($service->price, 2) }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Staff --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <label class="block text-sm font-semibold text-gray-700 mb-3">Staff Member</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach($staff as $member)
                <label class="cursor-pointer">
                    <input type="radio" name="staff_id" value="{{ $member->id }}"
                           {{ (old('staff_id', request('staff_id')) == $member->id) ? 'checked' : '' }}
                           class="sr-only" onchange="onSelectionChange()">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition hover:border-[#b5708a] staff-card-inner">
                        <div class="w-12 h-12 rounded-full mx-auto mb-2 flex items-center justify-center text-white font-bold text-lg"
                             style="background: linear-gradient(135deg, #b5708a, #d4a0b8)">
                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                        </div>
                        <div class="text-xs font-medium text-gray-700">{{ $member->user->name }}</div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Date --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <label for="date" class="block text-sm font-semibold text-gray-700 mb-3">Date</label>
            <input type="date" id="date" name="date"
                   min="{{ date('Y-m-d') }}"
                   value="{{ old('date') }}"
                   onchange="onSelectionChange()"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:border-transparent"
                   style="--tw-ring-color: #b5708a">
        </div>

        {{-- Time Slots --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100" id="slots-section">
            <label class="block text-sm font-semibold text-gray-700 mb-3">Available Times</label>

            <div id="slots-loading" class="hidden text-sm text-gray-400 text-center py-4">
                Loading available slots...
            </div>
            <div id="slots-empty" class="hidden text-sm text-red-500 text-center py-4">
                No available slots for this selection. Try a different date or staff member.
            </div>
            <div id="slots-prompt" class="text-sm text-gray-400 text-center py-4">
                Select a service, staff, and date to see available times.
            </div>
            <div id="slots-grid" class="grid grid-cols-3 sm:grid-cols-4 gap-2 hidden">
                {{-- Populated by JS --}}
            </div>
            <input type="hidden" name="time" id="time-input" value="{{ old('time') }}">
        </div>

        {{-- Notes --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-3">Notes <span class="text-gray-400 font-normal">(optional)</span></label>
            <textarea id="notes" name="notes" rows="3" maxlength="500"
                      placeholder="Any special requests or notes..."
                      class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 resize-none focus:outline-none focus:ring-2 focus:border-transparent"
                      style="--tw-ring-color: #b5708a">{{ old('notes') }}</textarea>
        </div>

        <button type="submit"
                class="w-full text-white font-semibold py-3 rounded-xl transition text-sm shadow hover:opacity-90"
                style="background:#b5708a">
            Confirm Booking
        </button>
    </form>
</div>

<style>
    input[type="radio"]:checked + .service-card-inner,
    input[type="radio"]:checked + .staff-card-inner {
        border-color: #b5708a;
        background-color: rgba(181,112,138,0.05);
    }
    .time-btn.selected {
        background: #b5708a;
        color: white;
        border-color: #b5708a;
    }
</style>

<script>
let selectedTime = '{{ old('time') }}';

function formatTime(t) {
    const [h, m] = t.split(':').map(Number);
    const ampm = h >= 12 ? 'PM' : 'AM';
    return `${h % 12 || 12}:${String(m).padStart(2,'0')} ${ampm}`;
}

function onSelectionChange() {
    const serviceId = document.querySelector('input[name="service_id"]:checked')?.value;
    const staffId   = document.querySelector('input[name="staff_id"]:checked')?.value;
    const date      = document.getElementById('date').value;

    if (!serviceId || !staffId || !date) return;

    document.getElementById('slots-prompt').classList.add('hidden');
    document.getElementById('slots-empty').classList.add('hidden');
    document.getElementById('slots-grid').classList.add('hidden');
    document.getElementById('slots-loading').classList.remove('hidden');

    fetch(`/book/slots?service_id=${serviceId}&staff_id=${staffId}&date=${date}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('slots-loading').classList.add('hidden');

        if (!data.slots || data.slots.length === 0) {
            document.getElementById('slots-empty').classList.remove('hidden');
            return;
        }

        const grid = document.getElementById('slots-grid');
        grid.innerHTML = '';
        data.slots.forEach(slot => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = formatTime(slot);
            btn.dataset.time = slot;
            btn.className = 'time-btn border-2 border-gray-200 rounded-xl py-2 text-sm font-medium text-gray-700 hover:border-[#b5708a] transition' + (slot === selectedTime ? ' selected' : '');
            btn.onclick = () => selectTime(slot);
            grid.appendChild(btn);
        });
        grid.classList.remove('hidden');

        // Restore previously selected time if available
        if (selectedTime && data.slots.includes(selectedTime)) {
            selectTime(selectedTime);
        }
    })
    .catch(() => {
        document.getElementById('slots-loading').classList.add('hidden');
        document.getElementById('slots-empty').classList.remove('hidden');
    });
}

function selectTime(t) {
    selectedTime = t;
    document.getElementById('time-input').value = t;
    document.querySelectorAll('.time-btn').forEach(b => {
        b.classList.toggle('selected', b.dataset.time === t);
    });
}

// Trigger load if old values are present
window.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('input[name="service_id"]:checked') &&
        document.querySelector('input[name="staff_id"]:checked') &&
        document.getElementById('date').value) {
        onSelectionChange();
    }
});
</script>
</x-app-layout>
