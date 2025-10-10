<?php

namespace App\Services\Administration\Appointment;

use App\Models\Appointment\Appointment;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AppointmentService
{
    public function getAppointmentsData(){
        $user = Auth::user();

        $appointments = match ($user->role) {
            'doctor' => Appointment::with('patient')->where('doctor_id', $user->id)->latest()->get(),
            'patient' => Appointment::with('doctor')->where('patient_id', $user->id)->latest()->get(),
            'admin' => Appointment::with(['doctor', 'patient'])->latest()->get(),
            default => []
        };
        return $appointments;
    }

    public function createAppointment(object $data){
        $appointment = Appointment::create([
            'doctor_id' => $data->doctor_id,
            'patient_id' => Auth::id(),
            'appointment_date' => $data->appointment_date,
            'appointment_time' => $data->appointment_time,
            'notes' => $data->notes,
        ]);

        $doctor = User::find($data->doctor_id);
        Notification::send($doctor, new AppointmentNotification($appointment));
    }

    public function updateAppointment(object $data, $appointment){
        $appointment->update([
            'status' => $data->status,
        ]);

        Notification::send($appointment->patient, new AppointmentNotification($appointment, true));
    }

    public function deleteAppointment($appointment){
        $appointment->delete();
    }
}