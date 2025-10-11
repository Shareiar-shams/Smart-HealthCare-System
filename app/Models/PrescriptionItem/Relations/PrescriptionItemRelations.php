<?php

namespace App\Models\PrescriptionItem\Relations;

use App\Models\Prescription\Prescription;

trait PrescriptionItemRelations
{
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}