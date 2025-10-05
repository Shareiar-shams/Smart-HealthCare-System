<?php

namespace App\Models\UserProfile\Relations;

use App\Models\User;

trait UserProfileRelations
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}