<?php

namespace App\Services\Administration\Appointment;

use App\Models\Appointment\Appointment;
use App\Models\Doctor\Doctor;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Carbon\Carbon;
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
    public function createAppointment(array $data)
    {
        try {
            // Decode the time slot JSON
            $timeSlot = json_decode($data['time_slot'], true);
            
            // Validate time slot availability
            $doctor = Doctor::findOrFail($data['doctor_id']);
            $date = Carbon::parse($data['date']);
            $existingAppointments = $this->getExistAppointmentsData($doctor, null, $date);
            
            // Check for time slot conflicts
            $startTime = Carbon::parse($data['date'] . ' ' . $timeSlot['start']);
            $endTime = Carbon::parse($data['date'] . ' ' . $timeSlot['end']);
            
            foreach ($existingAppointments as $existing) {
                $existingStart = Carbon::parse($existing->time_start);
                $existingEnd = Carbon::parse($existing->time_end);
                
                if ($startTime < $existingEnd && $endTime > $existingStart) {
                    throw new \Exception('Selected time slot is no longer available.');
                }
            }
            
            // Create the appointment
            $appointment = Appointment::create([
                'doctor_id' => $data['doctor_id'],
                'patient_id' => Auth::id(),
                'appointment_date' => $data['date'],
                'time_start' => $startTime,
                'time_end' => $endTime,
                'reason' => $data['reason'],
                'notes' => $data['notes'] ?? null,
                'status' => 'pending'
            ]);

            // Get the doctor's user record and send notification
            Notification::send($doctor->user, new AppointmentNotification($appointment));

            return $appointment;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create appointment: ' . $e->getMessage());
        }
    }

    public function updateAppointment(array $data, $appointment)
    {
        try {
            $timeSlot = json_decode($data['time_slot'], true);
            $date = Carbon::parse($data['date']);
            
            // Check for time slot conflicts
            $existingAppointments = $this->getExistAppointmentsData($appointment->doctor, $appointment->id, $date);
            $startTime = Carbon::parse($data['date'] . ' ' . $timeSlot['start']);
            $endTime = Carbon::parse($data['date'] . ' ' . $timeSlot['end']);
            
            foreach ($existingAppointments as $existing) {
                $existingStart = Carbon::parse($existing->time_start);
                $existingEnd = Carbon::parse($existing->time_end);
                
                if ($startTime < $existingEnd && $endTime > $existingStart) {
                    throw new \Exception('Selected time slot is no longer available.');
                }
            }

            $appointment->update([
                'appointment_date' => $data['date'],
                'time_start' => $startTime,
                'time_end' => $endTime,
                'reason' => $data['reason'],
                'notes' => $data['notes'] ?? null,
                'status' => $data['status'] ?? $appointment->status
            ]);

            // Send notification to both doctor and patient
            Notification::send($appointment->doctor->user, new AppointmentNotification($appointment, true));
            Notification::send($appointment->patient, new AppointmentNotification($appointment, true));

            return $appointment;
        } catch (\Exception $e) {
            throw new \Exception('Failed to update appointment: ' . $e->getMessage());
        }
    }

    public function deleteAppointment($appointment){
        $appointment->delete();
    }

    /**
     * Get doctor's working hours for a specific day
     */
    public function getDoctorWorkingHours(Doctor $doctor, $date): array
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

    public function getExistAppointmentsData($doctor, $currentAppointmentId = null, $date){
        $existingAppointment = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $date->format('Y-m-d'))
            ->when($currentAppointmentId, function ($query) use ($currentAppointmentId) {
                return $query->where('id', '!=', $currentAppointmentId);
            })
            ->where('status', '!=', 'cancelled')
            ->get();
        return $existingAppointment;
    }
    /**
     * Generate available time slots
     */
    public function generateTimeSlots(array $workingHours, $existingAppointments, $date): array
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

    public function date($date){
        return $date = Carbon::parse($date);
    }
}