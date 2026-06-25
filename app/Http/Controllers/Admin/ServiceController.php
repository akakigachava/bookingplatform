<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'price'            => 'required|numeric|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'price'            => 'required|numeric|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
