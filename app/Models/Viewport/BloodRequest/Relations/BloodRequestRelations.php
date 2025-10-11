<?php

namespace App\Models\Viewport\BloodRequest\Relations;

use App\Models\Viewport\Donor\Donor;

trait BloodRequestRelations
{
    // Remove the matches() relationship for now

    public function getAvailableDonors()
    {
        return Donor::where('blood_group', $this->blood_group)
                    ->where('division', $this->division)
                    ->where('availability', true)
                    ->where('is_verified', true)
                    ->get();
    }

}