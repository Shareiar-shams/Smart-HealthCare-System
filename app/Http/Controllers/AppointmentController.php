<?php

namespace App\Http\Controllers;

use App\Enums\DoctorSpecialty;
use App\Http\Requests\Administration\Appoinment\StoreAppointmentRequest;
use App\Http\Requests\Administration\Appoinment\UpdateAppointmentRequest;
use App\Models\Appointment\Appointment;
use App\Models\Doctor\Doctor;
use App\Services\Administration\Appointment\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $specialties = DoctorSpecialty::getValues();
        return view('admin.appointments.create', compact('doctors', 'specialties'));
    }

    /**
     * Get available time slots for a doctor on a specific date
     */
    public function getTimeSlots(Request $request, Doctor $doctor): JsonResponse
    {
        $date = Carbon::parse($request->date);
        $currentAppointmentId = $request->get('current_appointment_id');
        
        // Get doctor's schedule for the day (assuming doctor has working hours)
        $workingHours = $this->getDoctorWorkingHours($doctor, $date);
        
        // Get existing appointments
        $existingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $date->format('Y-m-d'))
            ->when($currentAppointmentId, function ($query) use ($currentAppointmentId) {
                return $query->where('id', '!=', $currentAppointmentId);
            })
            ->where('status', '!=', 'cancelled')
            ->get();

        // Generate available time slots
        $slots = $this->generateTimeSlots($workingHours, $existingAppointments, $date);

        return response()->json(['slots' => $slots]);
    }

    /**
     * Get doctor's working hours for a specific day
     */
    private function getDoctorWorkingHours(Doctor $doctor, Carbon $date): array
    {
        // This is a simplified example. In a real app, you'd fetch this from the doctor's schedule
        $defaultWorkingHours = [
            'start' => '09:00',
            'end' => '17:00',
            'slot_duration' => 30, // minutes
            'break_start' => '13:00',
            'break_end' => '14:00'
        ];

        // You can customize this based on the doctor's actual schedule
        // For example, different hours for different days, or fetching from a schedule table
        return $defaultWorkingHours;
    }

    /**
     * Generate available time slots
     */
    private function generateTimeSlots(array $workingHours, $existingAppointments, Carbon $date): array
    {
        $slots = [];
        $startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['start']);
        $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['end']);
        $breakStart = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['break_start']);
        $breakEnd = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['break_end']);

        while ($startTime < $endTime) {
            $slotEnd = $startTime->copy()->addMinutes($workingHours['slot_duration']);
            
            // Skip slots that fall in break time
            if (!($startTime >= $breakStart && $startTime < $breakEnd)) {
                $isAvailable = true;

                // Check if slot conflicts with existing appointments
                foreach ($existingAppointments as $appointment) {
                    $appointmentStart = Carbon::parse($appointment->time_start);
                    $appointmentEnd = Carbon::parse($appointment->time_end);

                    if ($startTime < $appointmentEnd && $slotEnd > $appointmentStart) {
                        $isAvailable = false;
                        break;
                    }
                }

                // Don't show past slots for today
                if ($date->isToday() && $startTime->isPast()) {
                    $isAvailable = false;
                }

                $slots[] = [
                    'start' => $startTime->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'formatted_time' => $startTime->format('g:i A') . ' - ' . $slotEnd->format('g:i A'),
                    'available' => $isAvailable
                ];
            }

            $startTime->addMinutes($workingHours['slot_duration']);
        }

        return $slots;
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
