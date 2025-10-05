<?php

namespace App\Models\Pharmacy\Relations;

use App\Models\User;

trait PharmacyRelations
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}