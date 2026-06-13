<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessHour;
use Illuminate\Http\Request;

class BusinessHourController extends Controller
{
    public function index()
    {
        $hours = BusinessHour::orderBy('day_of_week')->get()->keyBy('day_of_week');

        return view('admin.business-hours.index', compact('hours'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'days'               => 'array',
            'days.*.open_time'   => 'required|date_format:H:i',
            'days.*.close_time'  => 'required|date_format:H:i|after:days.*.open_time',
        ]);

        foreach (range(0, 6) as $day) {
            BusinessHour::updateOrCreate(
                ['day_of_week' => $day],
                [
                    'is_open'    => isset($request->days[$day]),
                    'open_time'  => $request->days[$day]['open_time'] ?? '09:00',
                    'close_time' => $request->days[$day]['close_time'] ?? '18:00',
                ]
            );
        }

        return redirect()->route('admin.business-hours.index')->with('success', 'Business hours saved.');
    }
}
