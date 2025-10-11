<?php

namespace App\Models\Appointment\Relations;

use App\Models\Doctor\Doctor;
use App\Models\User;

trait AppointmentRelations
{
    public function patient() { 
        return $this->belongsTo(User::class, 'patient_id'); 
    }
    public function doctor()  { 
        return $this->belongsTo(Doctor::class, 'doctor_id'); 
    }
}