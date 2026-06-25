<x-admin-layout>
<x-slot name="title">Edit Service</x-slot>

<div class="max-w-xl">
    <a href="{{ route('admin.services.index') }}" class="text-sm text-gray-400 hover:text-gray-600 mb-6 inline-flex items-center gap-1">
        &larr; Back to Services
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mt-4">
        <form method="POST" action="{{ route('admin.services.update', $service) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Name</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2"
                       style="--tw-ring-color:#b5708a">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                <select name="category"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 bg-white appearance-none focus:outline-none focus:ring-2 focus:border-transparent transition"
                        style="--tw-ring-color:#b5708a; background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E\"); background-repeat:no-repeat; background-position:right 12px center">
                    <option value="">— No category —</option>
                    @foreach(['Hair', 'Beard', 'Nails', 'Skin', 'Spa', 'Other'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $service->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm resize-none focus:outline-none focus:ring-2"
                          style="--tw-ring-color:#b5708a">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}"
                           min="15" max="480" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2"
                           style="--tw-ring-color:#b5708a">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (R)</label>
                    <input type="number" name="price" value="{{ old('price', $service->price) }}" step="0.01" min="0" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2"
                           style="--tw-ring-color:#b5708a">
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                       class="rounded border-gray-300" style="accent-color:#b5708a">
                <label for="is_active" class="text-sm text-gray-700">Active (visible to customers)</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="text-white text-sm font-medium px-6 py-2.5 rounded-xl transition"
                        style="background:#b5708a">Save Changes</button>
                <a href="{{ route('admin.services.index') }}"
                   class="text-sm font-medium text-gray-500 hover:text-gray-700 px-4 py-2.5">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
