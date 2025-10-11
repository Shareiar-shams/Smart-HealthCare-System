<?php

namespace App\Models\Prescription;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Prescription\Mutators\PrescriptionMutators;
use App\Models\Prescription\Accessors\PrescriptionAccessors;
use App\Models\Prescription\Relations\PrescriptionRelations;
use App\Models\Prescription\Scopes\PrescriptionScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\Prescription\PrescriptionObserver;

#[ObservedBy([PrescriptionObserver::class])]
class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use PrescriptionRelations;

    // Accessors & Mutators
    use PrescriptionAccessors, PrescriptionMutators;

    // Scopes
    use PrescriptionScopes;

    protected $casts = [];

    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'patient_id',
        'diagnosis',
        'instructions',
        'notes'
    ];
}