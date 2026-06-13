<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today'    => Appointment::whereDate('starts_at', today())->count(),
            'upcoming' => Appointment::where('starts_at', '>', now())
                ->whereIn('status', ['pending', 'confirmed'])->count(),
            'services' => Service::where('is_active', true)->count(),
            'staff'    => Staff::where('is_active', true)->count(),
        ];

        $todayAppointments = Appointment::with(['customer', 'staff.user', 'service'])
            ->whereDate('starts_at', today())
            ->orderBy('starts_at')
            ->get();

        $upcomingAppointments = Appointment::with(['customer', 'staff.user', 'service'])
            ->where('starts_at', '>', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('starts_at')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'todayAppointments', 'upcomingAppointments'));
    }
}
