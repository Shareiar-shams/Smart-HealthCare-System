<?php

namespace App\Models\Doctor\Relations;

use App\Models\User;

trait DoctorRelations
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}