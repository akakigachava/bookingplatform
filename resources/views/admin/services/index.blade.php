<x-admin-layout>
<x-slot name="title">Services</x-slot>

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">All Services</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage the treatments offered to customers.</p>
    </div>
    <a href="{{ route('admin.services.create') }}"
       class="inline-flex items-center gap-1.5 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition hover:opacity-90 active:scale-95"
       style="background:#b5708a">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Add Service
    </a>
</div>

{{-- Table card --}}
<div class="bg-white rounded-2xl overflow-hidden border border-gray-100"
     style="box-shadow: 0 1px 4px 0 rgba(0,0,0,0.06), 0 4px 16px 0 rgba(0,0,0,0.04)">

    @if($services->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4"
                 style="background:rgba(181,112,138,0.1)">
                <svg class="w-6 h-6" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-700">No services yet</p>
            <p class="text-xs text-gray-400 mt-1 mb-4">Add your first service to get started.</p>
            <a href="{{ route('admin.services.create') }}"
               class="text-white text-xs font-semibold px-4 py-2 rounded-lg transition hover:opacity-90"
               style="background:#b5708a">Add Service</a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#fafafa; border-bottom: 1px solid #f0eff0">
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3.5"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr class="group border-b border-gray-50 last:border-0 transition-colors duration-150"
                    style="background: white;"
                    onmouseenter="this.style.background='#fdf6f9'"
                    onmouseleave="this.style.background='white'">

                    {{-- Service name + description --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg shrink-0 flex items-center justify-center"
                                 style="background:rgba(181,112,138,0.1)">
                                <svg class="w-4 h-4" style="color:#b5708a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $service->name }}</div>
                                @if($service->description)
                                    <div class="text-xs text-gray-400 mt-0.5 line-clamp-1 max-w-xs">{{ $service->description }}</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Category --}}
                    <td class="px-6 py-4">
                        @if($service->category)
                            <span class="inline-flex text-xs font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(181,112,138,0.1); color:#b5708a">
                                {{ $service->category }}
                            </span>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>

                    {{-- Duration --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-sm text-gray-500">
                            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $service->duration_minutes }} min
                        </span>
                    </td>

                    {{-- Price --}}
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">R{{ number_format($service->price, 2) }}</span>
                    </td>

                    {{-- Status badge --}}
                    <td class="px-6 py-4">
                        @if($service->is_active)
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

                    {{-- Actions --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.services.edit', $service) }}"
                               class="inline-flex items-center gap-1 text-xs font-medium text-gray-600 border border-gray-200 px-3 py-1.5 rounded-lg bg-white hover:border-gray-300 hover:text-gray-800 transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                  onsubmit="return confirm('Delete this service? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-red-500 border border-red-200 px-3 py-1.5 rounded-lg bg-white hover:bg-red-50 hover:border-red-300 hover:text-red-700 transition-colors duration-150">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Table footer: row count --}}
        <div class="px-6 py-3 border-t border-gray-50 bg-gray-50/50">
            <p class="text-xs text-gray-400">
                {{ $services->count() }} {{ Str::plural('service', $services->count()) }} total
            </p>
        </div>
    @endif
</div>
</x-admin-layout>
