<?php

// app/Http/Controllers/AppointmentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'passport_no' => 'required|string',
            'phone_no' => 'required|string',
            'email' => 'required|email',
            'appt_date' => 'required|date',
            'appt_time' => 'required|string',
            'reason' => 'required|string',
        ]);

        Appointment::create($validatedData);

        return redirect()->route('appointments.create')->with('success', 'Appointment created successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $appointment->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function index()
    {
        $pendingAppointments = Appointment::where('status', 'pending')->get();
        $approvedAppointments = Appointment::where('status', 'approved')->get();
        $rejectedAppointments = Appointment::where('status', 'rejected')->get();

        return view('dashboard', compact('pendingAppointments', 'approvedAppointments', 'rejectedAppointments'));
    }
}
