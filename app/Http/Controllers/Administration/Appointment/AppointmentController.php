<?php

namespace App\Http\Controllers\Administration\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Appoinment\StoreAppointmentRequest;
use App\Http\Requests\Administration\Appoinment\UpdateAppointmentRequest;
use App\Http\Requests\Administration\Appointment\StoreAppointmentDocumentRequest;
use App\Models\Appointment\Appointment;
use App\Models\AppointmentDocument\AppointmentDocument;
use App\Models\Doctor\Doctor;
use App\Services\Administration\Appointment\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
        [$doctors, $specialties] = $this->appointmentService->getDcotorInformation();
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
            // Create appointment WITHOUT documents first
            $appointmentData = $request->validated();

            // Remove documents from appointment data if they exist
            unset($appointmentData['documents']);
            unset($appointmentData['document_types']);

            $appointment = $this->appointmentService->createAppointment($appointmentData);

            // Handle document uploads if files were provided
            if ($request->hasFile('documents')) {
                $this->handleDocumentUpload($request, $appointment);
            }

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

    /**
     * Handle document upload for an appointment
     */
    private function handleDocumentUpload(StoreAppointmentRequest $request, Appointment $appointment)
    {
        $files = $request->file('documents');
        $documentTypes = $request->input('document_types', []);

        if (!$files) return;

        foreach ($files as $index => $file) {
            if ($file && !$file->getError()) {
                $imageStore = $this->appointmentService->getImageService()->storeSingleImage($file, 'appointment_documents', null, null, null);

                $appointment->documents()->create([
                    'type' => $documentTypes[$index] ?? 'report',
                    'file_path' => $imageStore,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }
    }

    /**
     * Store newly created documents in storage.
     */
    public function documentsStore(StoreAppointmentDocumentRequest $request, Appointment $appointment)
    {

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $imageStore = $this->appointmentService->getImageService()->storeSingleImage($file, 'appointment_documents', null, null, null);

                $appointment->documents()->create([
                    'type' => $request->type,
                    'file_path' => $imageStore,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Documents uploaded successfully!'
        ]);
    }

    // Show doctor detail and booking form
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        [$doctors, $specialties] = $this->appointmentService->getDcotorInformation();
        return view('admin.appointments.edit', compact('appointment', 'doctors', 'specialties'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        try {
            // if (!$appointment->canBeEdited()) {
            //     throw new \Exception('This appointment cannot be edited.');
            // }

            $this->appointmentService->updateAppointment($request->validated(), $appointment);
            
            return redirect()->route('administration.appointment.myAppointments')->with([
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

    public function documentsDestroy($id)
    {
        $document = AppointmentDocument::findOrFail($id);
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted successfully!');
    }

    // Show current user's appointments
    public function myAppointments()
    {
        $appointments = Appointment::with('doctor')->where('patient_id', Auth::id())->orderBy('appointment_date', 'desc')->paginate(12);
        return view('admin.appointments.my', compact('appointments'));
    }

    public function myPatientsAppointments(){
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Access denied. User is not a doctor.');
        }

        // Get appointments for this doctor with relationships
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('doctor_id', Auth::user()->doctor->id)
            ->orderBy('start_at', 'desc')
            ->paginate(12);
        // Get stats for this doctor
        $stats = $this->appointmentService->getDoctorStats($doctor);

        // Get today's appointments for schedule
        $todayAppointments = Appointment::with(['patient'])
            ->where('doctor_id', Auth::user()->doctor->id)
            ->whereDate('start_at', Carbon::today())
            ->orderBy('start_at')
            ->get();

        // Get recent activity (appointments from last 7 days)
        $recentActivity = Appointment::with(['patient'])
            ->where('doctor_id', Auth::user()->doctor->id)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.appointments.doctor.manage', compact('appointments', 'stats', 'todayAppointments', 'recentActivity'));
    }

    public function doctorAppointments(Request $request){
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Access denied. User is not a doctor.');
        }

        $query = Appointment::with(['patient', 'doctor'])
            ->where('doctor_id', Auth::user()->doctor->id);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('reason', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $date = Carbon::parse($request->input('date'))->toDateString();
            $query->whereDate('start_at', $date);
        }

        $appointments = $query->orderBy('start_at', 'desc')->paginate(12);

        return view('admin.appointments.doctor._appointments_list', compact('appointments'))->render();
    }

    public function confirm(string $id){
        $appointment = Appointment::findOrFail($id);
        try {
            if ($appointment->doctor_id !== Auth::user()->doctor->id) {
                abort(403, 'Access denied.');
            }

            $appointment->update(['status' => 'confirmed']);

            return redirect()->back()->with([
                'message' => 'Appointment confirmed successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Failed to confirm appointment: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function reject(Request $request, string $id){
        $appointment = Appointment::findOrFail($id);
        try {
            if ($appointment->doctor_id !== Auth::user()->doctor->id) {
                abort(403, 'Access denied.');
            }

            $appointment->update([
                'status' => 'cancelled',
                'canceled_by' => Auth::user()->doctor->id,
                'canceled_at' => Carbon::now(),
                'notes' => $request->input('cancel_reason', $appointment->notes)
            ]);

            return redirect()->back()->with([
                'message' => 'Appointment rejected successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Failed to reject appointment: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
