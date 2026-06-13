<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\BusinessHour;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function book()
    {
        $services = Service::where('is_active', true)->get();
        $staff = Staff::where('is_active', true)->with('user')->get();

        return view('appointments.book', compact('services', 'staff'));
    }

    public function availableSlots(Request $request)
    {
        $request->validate([
            'staff_id'   => 'required|exists:staff,id',
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date|after_or_equal:today',
        ]);

        $date = Carbon::parse($request->date);
        $service = Service::findOrFail($request->service_id);

        $businessHour = BusinessHour::where('day_of_week', $date->dayOfWeek)->first();

        if (!$businessHour || !$businessHour->is_open) {
            return response()->json(['slots' => []]);
        }

        $open  = Carbon::parse($date->toDateString() . ' ' . $businessHour->open_time);
        $close = Carbon::parse($date->toDateString() . ' ' . $businessHour->close_time);

        $booked = Appointment::where('staff_id', $request->staff_id)
            ->whereDate('starts_at', $date)
            ->whereNotIn('status', ['cancelled'])
            ->get();

        $slots   = [];
        $current = $open->copy();
        $now     = now();

        while ($current->copy()->addMinutes($service->duration_minutes)->lte($close)) {
            $slotEnd = $current->copy()->addMinutes($service->duration_minutes);

            $conflict = $booked->first(function ($appt) use ($current, $slotEnd) {
                return $appt->starts_at < $slotEnd && $appt->ends_at > $current;
            });

            if (!$conflict && $current->gt($now)) {
                $slots[] = $current->format('H:i');
            }

            $current->addMinutes($service->duration_minutes);
        }

        return response()->json(['slots' => $slots]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'staff_id'   => 'required|exists:staff,id',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required|date_format:H:i',
            'notes'      => 'nullable|string|max:500',
        ]);

        $service  = Service::findOrFail($validated['service_id']);
        $startsAt = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $endsAt   = $startsAt->copy()->addMinutes($service->duration_minutes);

        $conflict = Appointment::where('staff_id', $validated['staff_id'])
            ->whereNotIn('status', ['cancelled'])
            ->where('starts_at', '<', $endsAt)
            ->where('ends_at', '>', $startsAt)
            ->exists();

        if ($conflict) {
            return back()->withErrors(['time' => 'This slot is no longer available. Please choose another time.'])->withInput();
        }

        $appointment = Appointment::create([
            'customer_id' => auth()->id(),
            'staff_id'    => $validated['staff_id'],
            'service_id'  => $validated['service_id'],
            'starts_at'   => $startsAt,
            'ends_at'     => $endsAt,
            'status'      => 'pending',
            'notes'       => $validated['notes'] ?? null,
        ]);

        try {
            Mail::to(auth()->user()->email)
                ->send(new AppointmentConfirmation($appointment->load(['service', 'staff.user'])));
        } catch (\Exception) {
            // Email failure must not break the booking
        }

        return redirect()->route('customer.bookings')
            ->with('success', 'Booking confirmed! See you on ' . $startsAt->format('M j, Y \a\t g:i A') . '.');
    }

    public function myBookings()
    {
        $appointments = Appointment::with(['service', 'staff.user'])
            ->where('customer_id', auth()->id())
            ->orderBy('starts_at', 'desc')
            ->get();

        return view('customer.bookings', compact('appointments'));
    }

    public function cancel(Appointment $appointment)
    {
        abort_if($appointment->customer_id !== auth()->id(), 403);

        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('customer.bookings')->with('success', 'Appointment cancelled.');
    }
}
