<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin() || $user->isStaff()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.bookings');
    }
}
