<?php

namespace App\Models\User\Relations;

use App\Models\Doctor\Doctor;
use App\Models\Pharmacy\Pharmacy;
use App\Models\UserProfile\UserProfile;
use Spatie\Permission\Models\Role;

trait UserRelations
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function pharmacy()
    {
        return $this->hasOne(Pharmacy::class);
    }
}