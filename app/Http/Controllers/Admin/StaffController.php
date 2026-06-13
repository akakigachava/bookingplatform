<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('user')
            ->latest()
            ->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(8)],
            'bio'      => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'staff',
        ]);

        Staff::create([
            'user_id'   => $user->id,
            'bio'       => $request->bio,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', $request->name . ' has been added to the team.');
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $staff->user_id,
            'bio'      => 'nullable|string|max:500',
            'password' => ['nullable', Password::min(8)],
        ]);

        $staff->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $staff->user->update(['password' => Hash::make($request->password)]);
        }

        $staff->update([
            'bio'       => $request->bio,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', $request->name . '\'s profile has been updated.');
    }

    public function destroy(Staff $staff)
    {
        $name = $staff->user->name;
        $staff->user->delete(); // cascades to staff record

        return redirect()->route('admin.staff.index')
            ->with('success', $name . ' has been removed.');
    }
}
