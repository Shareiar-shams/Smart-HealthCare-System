<?php

namespace App\Models\AppointmentDocument\Relations;

use App\Models\Appointment\Appointment;

trait AppointmentDocumentRelations
{
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Optional: Accessor to get full file URL
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}