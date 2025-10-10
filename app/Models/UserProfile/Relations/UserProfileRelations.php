<?php

namespace App\Models\UserProfile\Relations;

use App\Models\Appointment\Appointment;
use App\Models\User;

trait UserProfileRelations
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctorAppointments()  { 
        return $this->hasMany(Appointment::class,'doctor_id'); 
    }

}