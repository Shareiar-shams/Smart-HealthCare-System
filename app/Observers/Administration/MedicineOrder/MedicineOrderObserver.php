<?php

namespace App\Observers\Administration\MedicineOrder;

use App\Models\MedicineOrder\MedicineOrder;

class MedicineOrderObserver
{
    /**
     * Handle the MedicineOrder "created" event.
     */
    public function created(MedicineOrder $medicineOrder): void
    {
        //
    }

    /**
     * Handle the MedicineOrder "updated" event.
     */
    public function updated(MedicineOrder $medicineOrder): void
    {
        //
    }

    /**
     * Handle the MedicineOrder "deleted" event.
     */
    public function deleted(MedicineOrder $medicineOrder): void
    {
        //
    }

    /**
     * Handle the MedicineOrder "restored" event.
     */
    public function restored(MedicineOrder $medicineOrder): void
    {
        //
    }

    /**
     * Handle the MedicineOrder "force deleted" event.
     */
    public function forceDeleted(MedicineOrder $medicineOrder): void
    {
        //
    }
}
