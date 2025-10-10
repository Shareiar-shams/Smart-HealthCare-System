<?php

namespace App\Models\Appointment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Appointment\Mutators\AppointmentMutators;
use App\Models\Appointment\Accessors\AppointmentAccessors;
use App\Models\Appointment\Relations\AppointmentRelations;
use App\Models\Appointment\Scopes\AppointmentScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\Appointment\AppointmentObserver;

#[ObservedBy([AppointmentObserver::class])]
class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use AppointmentRelations;

    // Accessors & Mutators
    use AppointmentAccessors, AppointmentMutators;

    // Scopes
    use AppointmentScopes;

    protected $casts = [];

    protected $fillable = [
        'patient_id','doctor_id','start_at','end_at','duration','status','reason','notes','canceled_by','canceled_at'
    ];

    protected $dates = ['start_at','end_at','canceled_at'];
}