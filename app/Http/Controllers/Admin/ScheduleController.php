<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class ScheduleController extends Controller
{
    public function index()
    {
        $staff = auth()->user()->staff;

        abort_if(!$staff, 403);

        $today = Appointment::with(['customer', 'service'])
            ->where('staff_id', $staff->id)
            ->whereDate('starts_at', today())
            ->orderBy('starts_at')
            ->get();

        $upcoming = Appointment::with(['customer', 'service'])
            ->where('staff_id', $staff->id)
            ->whereDate('starts_at', '>', today())
            ->where('starts_at', '<=', now()->addDays(7))
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('starts_at')
            ->get();

        return view('admin.schedule', compact('today', 'upcoming', 'staff'));
    }
}
