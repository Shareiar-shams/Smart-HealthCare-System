<?php

namespace App\Observers\Administration\AppointmentDocument;

use App\Models\AppointmentDocument\AppointmentDocument;

class AppointmentDocumentObserver
{
    /**
     * Handle the AppointmentDocument "created" event.
     */
    public function created(AppointmentDocument $appointmentDocument): void
    {
        //
    }

    /**
     * Handle the AppointmentDocument "updated" event.
     */
    public function updated(AppointmentDocument $appointmentDocument): void
    {
        //
    }

    /**
     * Handle the AppointmentDocument "deleted" event.
     */
    public function deleted(AppointmentDocument $appointmentDocument): void
    {
        //
    }

    /**
     * Handle the AppointmentDocument "restored" event.
     */
    public function restored(AppointmentDocument $appointmentDocument): void
    {
        //
    }

    /**
     * Handle the AppointmentDocument "force deleted" event.
     */
    public function forceDeleted(AppointmentDocument $appointmentDocument): void
    {
        //
    }
}
