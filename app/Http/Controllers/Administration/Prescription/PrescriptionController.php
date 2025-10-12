<?php

namespace App\Http\Controllers\Administration\Prescription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prescription\StorePrescription;
use App\Http\Requests\Prescription\UpdatePrescription;
use App\Services\Administration\Prescription\PrescriptionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class PrescriptionController extends Controller
{
    protected $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = $this->prescriptionService->getAllPrescriptions();
        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($appointmentId)
    {
        $appointment = $this->prescriptionService->getAppointmentWithPatients($appointmentId);
        return view('admin.prescriptions.doctor.create', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrescription $request)
    {
         try {
            $appointment = $this->prescriptionService->createPrescription($request);
            $notofication = array(
                'message' => 'Prescription created successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('administration.appointment.myPatientsAppointments')->with($notofication);
        } catch (Exception $e) {
            $notofication = array(
                'message' => 'Something went wrong! ' . $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notofication);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prescription = $this->prescriptionService->getPrescriptionData($id);

        return view('admin.prescriptions.patient.show', compact('prescription'));
    }

    public function downloadPdf($appointmentId)
    {
        $prescription = $this->prescriptionService->getPrescriptionData($appointmentId);

        $pdf = Pdf::loadView('prescriptions.pdf', compact('prescription'));
        return $pdf->download('prescription_' . $appointmentId . '.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrescription $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
