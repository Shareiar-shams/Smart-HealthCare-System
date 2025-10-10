<?php

namespace App\Models\Doctor\Relations;

use App\Models\Appointment\Appointment;
use App\Models\User;

trait DoctorRelations
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patientAppointments() { 
        return $this->hasMany(Appointment::class,'patient_id'); 
    }

}