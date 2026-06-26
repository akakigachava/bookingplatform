<x-admin-layout>
<x-slot name="title">Services</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-bold" style="font-size:22px; color:#0b1c30;">Services</h2>
        <p class="text-sm mt-0.5" style="color:#514348;">Manage the treatments offered to customers.</p>
    </div>
    <a href="{{ route('admin.services.create') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-white px-4 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
       style="background:#864461;">
        <span class="material-symbols-outlined" style="font-size:16px; font-variation-settings:'FILL' 1;">add_circle</span>
        Add Service
    </a>
</div>

{{-- Table card --}}
<div class="rounded-xl overflow-hidden"
     style="background:#ffffff; border:1px solid #d3e4fe; box-shadow:0 1px 4px rgba(0,0,0,0.04);">

    @if($services->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <span class="material-symbols-outlined mb-3" style="font-size:48px; color:#d6c1c7;">category</span>
            <p class="text-sm font-semibold" style="color:#0b1c30;">No services yet</p>
            <p class="text-xs mt-1 mb-5" style="color:#847378;">Add your first service to get started.</p>
            <a href="{{ route('admin.services.create') }}"
               class="text-xs font-semibold px-4 py-2 rounded-xl text-white transition hover:opacity-90"
               style="background:#864461;">Add Service</a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#f8f9ff; border-bottom:1px solid #eff4ff;">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Service</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Category</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Duration</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Price</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:#514348;">Status</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr style="border-bottom:1px solid #eff4ff; background:white;"
                    onmouseenter="this.style.background='#f8f9ff'"
                    onmouseleave="this.style.background='white'">

                    {{-- Service name --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                                 style="background:#ffd9e5;">
                                <span class="material-symbols-outlined" style="font-size:18px; color:#864461; font-variation-settings:'FILL' 1;">spa</span>
                            </div>
                            <div>
                                <div class="font-semibold" style="color:#0b1c30;">{{ $service->name }}</div>
                                @if($service->description)
                                    <div class="text-xs mt-0.5 max-w-xs truncate" style="color:#847378;">{{ $service->description }}</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Category --}}
                    <td class="px-5 py-4">
                        @if($service->category)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                  style="background:#ffd9e5; color:#864461;">
                                {{ $service->category }}
                            </span>
                        @else
                            <span style="color:#d6c1c7;">—</span>
                        @endif
                    </td>

                    {{-- Duration --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-1.5" style="color:#514348;">
                            <span class="material-symbols-outlined" style="font-size:15px; color:#847378;">schedule</span>
                            <span class="font-medium">{{ $service->duration_minutes }} min</span>
                        </div>
                    </td>

                    {{-- Price --}}
                    <td class="px-5 py-4">
                        <span class="font-bold" style="color:#0b1c30; font-size:15px;">R{{ number_format($service->price, 2) }}</span>
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-4">
                        @if($service->is_active)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                  style="background:#bcedda; color:#204f41;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background:#356253;"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                                  style="background:#e5eeff; color:#514348;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background:#847378;"></span>
                                Inactive
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.services.edit', $service) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-xl border transition-colors"
                               style="color:#514348; border-color:#d6c1c7; background:white;"
                               onmouseenter="this.style.background='#eff4ff'"
                               onmouseleave="this.style.background='white'">
                                <span class="material-symbols-outlined" style="font-size:13px;">edit</span>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($service->name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-xl border transition-colors"
                                        style="color:#ba1a1a; border-color:#f9b4af; background:white;"
                                        onmouseenter="this.style.background='#ffdad6'"
                                        onmouseleave="this.style.background='white'">
                                    <span class="material-symbols-outlined" style="font-size:13px;">delete</span>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-5 py-3" style="border-top:1px solid #eff4ff; background:#f8f9ff;">
            <p class="text-xs" style="color:#847378;">{{ $services->count() }} {{ Str::plural('service', $services->count()) }} total</p>
        </div>
    @endif
</div>
</x-admin-layout>
