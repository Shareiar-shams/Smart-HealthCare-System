<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Doctor\Mutators\DoctorMutators;
use App\Models\Doctor\Accessors\DoctorAccessors;
use App\Models\Doctor\Relations\DoctorRelations;
use App\Models\Doctor\Scopes\DoctorScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\Doctor\DoctorObserver;

#[ObservedBy([DoctorObserver::class])]
class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use DoctorRelations;

    // Accessors & Mutators
    use DoctorAccessors, DoctorMutators;

    // Scopes
    use DoctorScopes;

    protected $casts = [];

    protected $fillable = ['user_id', 'specialty', 'qualification',
        'experience_years', 'license_number', 'chamber_address', 'consultation_fee', 'available_days', 'available_time', 'duration', 'bio'];
}