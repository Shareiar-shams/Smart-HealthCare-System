<?php

namespace App\Observers\Administration\PrescriptionItem;

use App\Models\PrescriptionItem\PrescriptionItem;

class PrescriptionItemObserver
{
    /**
     * Handle the PrescriptionItem "created" event.
     */
    public function created(PrescriptionItem $prescriptionItem): void
    {
        //
    }

    /**
     * Handle the PrescriptionItem "updated" event.
     */
    public function updated(PrescriptionItem $prescriptionItem): void
    {
        //
    }

    /**
     * Handle the PrescriptionItem "deleted" event.
     */
    public function deleted(PrescriptionItem $prescriptionItem): void
    {
        //
    }

    /**
     * Handle the PrescriptionItem "restored" event.
     */
    public function restored(PrescriptionItem $prescriptionItem): void
    {
        //
    }

    /**
     * Handle the PrescriptionItem "force deleted" event.
     */
    public function forceDeleted(PrescriptionItem $prescriptionItem): void
    {
        //
    }
}
