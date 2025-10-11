<?php

namespace App\Services\Administration\Prescription;

use App\Models\Appointment\Appointment;
use App\Models\Prescription\Prescription;
use Illuminate\Support\Facades\Auth;

class PrescriptionService
{
    public function getAllPrescriptions(){
        return Prescription::with('doctor', 'patient')->latest();
    }
    public function getAppointmentWithPatients($appointmentId){
        return Appointment::with('patient')->findOrFail($appointmentId);
    }

    public function getAppointment($id){
        return Appointment::findOrFail($id);
    }

    public function createPrescription($request){
        $appointment = $this->getAppointment($request->appointment_id);

        $prescription = Prescription::create([
            'appointment_id' => $appointment->id,
            'doctor_id' => Auth::user()->dector->id,
            'patient_id' => $appointment->patient_id,
            'diagnosis' => $request->diagnosis,
            'instructions' => $request->instructions,
        ]);

        foreach ($request->items as $item) {
            $prescription->items()->create($item);
        }
        return $prescription;
    }

    public function getPrescriptionData($id) {
        return Prescription::with('items', 'doctor', 'patient', 'appointment')
            ->where('appointment_id', $id)
            ->firstOrFail();
    }
}