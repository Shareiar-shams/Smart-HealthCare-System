<?php

namespace App\Models\Prescription\Relations;

use App\Models\Appointment\Appointment;
use App\Models\Doctor\Doctor;
use App\Models\PrescriptionItem\PrescriptionItem;
use App\Models\User;

trait PrescriptionRelations
{
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
        
    }
}