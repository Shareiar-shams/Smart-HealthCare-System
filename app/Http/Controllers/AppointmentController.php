<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'myAppointments']);
    }

    // List doctors (simple index)
    public function index()
    {
        $doctors = Doctor::where('status', true)->paginate(12);
        return view('appointments.doctors', compact('doctors'));
    }

    // Show doctor detail and booking form
    public function show(Doctor $doctor)
    {
        return view('appointments.doctor', compact('doctor'));
    }

    // Store appointment
    public function store(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required'],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'date' => $data['date'],
            'time' => $data['time'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.my')->with('success', 'Appointment requested successfully.');
    }

    // Show current user's appointments
    public function myAppointments()
    {
        $appointments = Appointment::with('doctor')->where('user_id', Auth::id())->orderBy('date', 'desc')->paginate(12);
        return view('appointments.my', compact('appointments'));
    }
}
