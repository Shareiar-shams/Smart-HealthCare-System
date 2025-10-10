<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Pharmacy\Mutators\PharmacyMutators;
use App\Models\Pharmacy\Accessors\PharmacyAccessors;
use App\Models\Pharmacy\Relations\PharmacyRelations;
use App\Models\Pharmacy\Scopes\PharmacyScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\Pharmacy\PharmacyObserver;

#[ObservedBy([PharmacyObserver::class])]
class Pharmacy extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use PharmacyRelations;

    // Accessors & Mutators
    use PharmacyAccessors, PharmacyMutators;

    // Scopes
    use PharmacyScopes;

    protected $casts = [];

    protected $fillable = ['user_id', 'pharmacy_name', 'owner_name',
        'license_number', 'contact_no', 'address', 'city', 'state', 'postal_code', 'opening_hours', 'delivery_available', 'emergency_service', 'description'];
}