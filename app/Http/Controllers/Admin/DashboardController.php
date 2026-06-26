<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyRevenue = Appointment::where('status', 'completed')
            ->whereMonth('starts_at', now()->month)
            ->whereYear('starts_at', now()->year)
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');

        $stats = [
            'today'     => Appointment::whereDate('starts_at', today())->count(),
            'upcoming'  => Appointment::where('starts_at', '>', now())
                ->whereIn('status', ['pending', 'confirmed'])->count(),
            'customers' => User::where('role', 'customer')->count(),
            'revenue'   => $monthlyRevenue,
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
