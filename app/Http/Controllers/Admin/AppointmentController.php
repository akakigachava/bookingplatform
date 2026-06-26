<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['customer', 'staff.user', 'service'])
            ->orderBy('starts_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('starts_at', $request->date);
        }

        $appointments = $query->paginate(20)->withQueryString();

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $customers = User::where('role', 'customer')->orderBy('name')->get();
        $services  = Service::where('is_active', true)->get();
        $staff     = Staff::where('is_active', true)->with('user')->get();

        return view('admin.appointments.create', compact('customers', 'services', 'staff'));
    }

    public function store(Request $request)
    {
        $isWalkin = !$request->filled('customer_id');

        $request->validate([
            'customer_id' => $isWalkin ? 'nullable' : 'required|exists:users,id',
            'walkin_name' => $isWalkin ? 'required|string|max:255' : 'nullable',
            'walkin_email'=> $isWalkin ? 'nullable|email|unique:users,email' : 'nullable',
            'service_id'  => 'required|exists:services,id',
            'staff_id'    => 'required|exists:staff,id',
            'date'        => 'required|date|after_or_equal:today',
            'time'        => 'required',
            'notes'       => 'nullable|string|max:500',
        ]);

        if ($isWalkin) {
            $email = $request->filled('walkin_email')
                ? $request->walkin_email
                : 'walkin.' . Str::random(8) . '@bookease.local';

            $customer = User::create([
                'name'     => $request->walkin_name,
                'email'    => $email,
                'password' => Hash::make(Str::random(16)),
                'role'     => 'customer',
            ]);
        } else {
            $customer = User::findOrFail($request->customer_id);
        }

        $service   = Service::findOrFail($request->service_id);
        $startsAt  = Carbon::parse($request->date . ' ' . $request->time);
        $endsAt    = $startsAt->copy()->addMinutes($service->duration_minutes);

        $conflict = Appointment::where('staff_id', $request->staff_id)
            ->whereNotIn('status', ['cancelled'])
            ->where(function ($q) use ($startsAt, $endsAt) {
                $q->whereBetween('starts_at', [$startsAt, $endsAt->subSecond()])
                  ->orWhereBetween('ends_at', [$startsAt->addSecond(), $endsAt])
                  ->orWhere(function ($q) use ($startsAt, $endsAt) {
                      $q->where('starts_at', '<=', $startsAt)
                        ->where('ends_at', '>=', $endsAt);
                  });
            })->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'That time slot is already booked. Please choose another.');
        }

        $appointment = Appointment::create([
            'customer_id' => $customer->id,
            'service_id'  => $request->service_id,
            'staff_id'    => $request->staff_id,
            'starts_at'   => $startsAt,
            'ends_at'     => $endsAt,
            'status'      => 'confirmed',
            'notes'       => $request->notes,
        ]);

        // Send confirmation email to registered customers (not walk-ins with placeholder emails)
        if (!str_contains($customer->email, '@bookease.local')) {
            try {
                Mail::to($customer->email)
                    ->send(new AppointmentConfirmation($appointment->load(['service', 'staff.user', 'customer'])));
            } catch (\Exception) {
                // Email failure must not break the booking
            }
        }

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment booked and confirmed.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled,completed']);

        $appointment->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated.');
    }
}
