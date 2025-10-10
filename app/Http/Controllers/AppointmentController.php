<?php

namespace App\Http\Controllers;

use App\Http\Requests\Administration\Appoinment\StoreAppointmentRequest;
use App\Http\Requests\Administration\Appoinment\UpdateAppointmentRequest;
use App\Models\Appointment\Appointment;
use App\Models\Doctor\Doctor;
use App\Services\Administration\Appointment\AppointmentService;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    protected $appointmentService;
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
        $this->middleware('role:Patient')->only(['store', 'myAppointments']);
        $this->middleware('role:Super Admin')->only(['index', 'store', 'show', 'myAppointments', 'destroy']);
    }

    // List doctors (simple index)
    public function index()
    {
        $appointments = $this->appointmentService->getAppointmentsData();
        return view('admin.appointments.my', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.appointments.create', compact('doctors'));
    }
    // Show doctor detail and booking form
    public function show(Doctor $doctor)
    {
        return view('admin.appointments.doctor', compact('doctor'));
    }

    // Store appointment
    public function store(StoreAppointmentRequest $request)
    {
        $this->appointmentService->createAppointment($request->validated());
        $notification = [
            'message' => 'Appointment booked successfully!',
            'alert-type' => 'success'
        ];
        return back()->with($notification);
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
    
        $this->appointmentService->updateAppointment($request->validated(), $appointment);
        $notification = [
            'message' => 'Appointment updated successfully!',
            'alert-type' => 'success'
        ];
        return back()->with($notification);
    }
    
    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->deleteAppointment($appointment);
        $notification = [
            'message' => 'Appointment deleted successfully!',
            'alert-type' => 'success'
        ];
        return back()->with($notification);
    }

    // Show current user's appointments
    public function myAppointments()
    {
        $appointments = Appointment::with('doctor')->where('user_id', Auth::id())->orderBy('date', 'desc')->paginate(12);
        return view('admin.appointments.my', compact('appointments'));
    }
}
