<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('appointments')
            ->with(['appointments' => fn($q) => $q->latest('starts_at')->limit(1)])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.customers.index', compact('customers'));
    }
}
