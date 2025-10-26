<?php

namespace App\Services\Administration\Prescription;

use App\Models\Appointment\Appointment;
use App\Models\Prescription\Prescription;
use Illuminate\Support\Facades\Auth;

class PrescriptionService
{
    public function getAllPrescriptions(){
        return Prescription::with(['doctor.user', 'patient.profile', 'items'])->latest()->paginate(12);
    }

    public function getUserAllPrescriptions($userId)
    {
        return Prescription::with(['doctor.user', 'items', 'patient.profile'])
            ->whereHas('patient', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->get();
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
            'doctor_id' => Auth::user()->doctor->id,
            'patient_id' => $appointment->patient_id,
            'diagnosis' => $request->diagnosis,
            'instructions' => $request->instructions,
            'notes' => $request->notes,
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $prescription->items()->create([
                    'medicine_name' => $item['medicine_name'],
                    'dosage' => $item['dosage'],
                    'duration' => $item['duration'],
                    'frequency' => $item['frequency']
                ]);
            }
        }
        return $prescription;
    }

    public function getPrescriptionData($id) {
        return Prescription::with('items', 'doctor', 'patient', 'appointment')
            ->where('appointment_id', $id)
            ->firstOrFail();
    }
}