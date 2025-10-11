<?php

namespace App\Http\Controllers;

use App\Enums\DoctorSpecialty;
use App\Http\Requests\Administration\Appoinment\StoreAppointmentRequest;
use App\Http\Requests\Administration\Appoinment\UpdateAppointmentRequest;
use App\Models\Appointment\Appointment;
use App\Models\Doctor\Doctor;
use App\Services\Administration\Appointment\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class AppointmentController extends Controller
{
    protected $appointmentService;
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
        $this->middleware('role:Super Admin|Patient')->only(['store', 'myAppointments', 'show']);
        $this->middleware('role:Super Admin')->only(['index', 'destroy']);
    }

    // List appointments with filters, stats and charts for admin
    public function index(Request $request)
    {
        
        $appointments = $this->appointmentService->filterdAppointmentData($request);

        // If AJAX, return just the list partial for dynamic updates
        if ($request->ajax()) {
            return view('admin.appointments.admin._list', compact('appointments'))->render();
        }

        // Data for filters and stats
        $doctors = $this->appointmentService->getDoctors();

        $stats = $this->appointmentService->getStats();

        $charts = $this->appointmentService->getChartsData();

        return view('admin.appointments.admin.index', compact('appointments', 'doctors', 'stats', 'charts'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        $specialties = DoctorSpecialty::getValues();
        return view('admin.appointments.create', compact('doctors', 'specialties'));
    }

    /**
     * Get available time slots for a doctor on a specific date
     */
    public function getTimeSlots(Request $request, Doctor $doctor): JsonResponse
    {
        $date = $this->appointmentService->date($request->date);
        $currentAppointmentId = $request->get('current_appointment_id');
        
        // Get doctor's schedule for the day (assuming doctor has working hours)
        $workingHours = $this->appointmentService->getDoctorWorkingHours($doctor, $date);
        
        // Get existing appointments
        $existingAppointments = $this->appointmentService->getExistAppointmentsData($doctor, $currentAppointmentId, $date);
        // Generate available time slots
        $slots = $this->appointmentService->generateTimeSlots($workingHours, $existingAppointments, $date);

        return response()->json(['slots' => $slots]);
    }

    /**
     * Store a new appointment.
     *
     * @param StoreAppointmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAppointmentRequest $request)
    {
        try {
            $appointment = $this->appointmentService->createAppointment($request->validated());
            
            return redirect()->route('administration.appointment.myAppointments')->with([
                'message' => 'Appointment booked successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Failed to book appointment. ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    // Show doctor detail and booking form
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::with('user')->get();
        $specialties = DoctorSpecialty::getValues();
        return view('admin.appointments.edit', compact('appointment', 'doctors', 'specialties'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        try {
            if (!$appointment->canBeEdited()) {
                throw new \Exception('This appointment cannot be edited.');
            }

            $this->appointmentService->updateAppointment($request->validated(), $appointment);
            
            return redirect()->route('administration.appointment.show', $appointment->id)->with([
                'message' => 'Appointment updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Failed to update appointment: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
    
    public function destroy(Appointment $appointment)
    {
        try {
            if (!$appointment->canBeCancelled()) {
                throw new \Exception('This appointment cannot be cancelled.');
            }

            $this->appointmentService->deleteAppointment($appointment);
            
            return redirect()->route('administration.appointment.index')->with([
                'message' => 'Appointment cancelled successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Failed to cancel appointment: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    // Show current user's appointments
    public function myAppointments()
    {
        $appointments = Appointment::with('doctor')->where('patient_id', Auth::id())->orderBy('appointment_date', 'desc')->paginate(12);
        return view('admin.appointments.my', compact('appointments'));
    }
}
