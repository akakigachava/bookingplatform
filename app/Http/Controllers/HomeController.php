<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Staff;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        $staff = Staff::where('is_active', true)->with('user')->get();

        return view('welcome', compact('services', 'staff'));
    }
}
