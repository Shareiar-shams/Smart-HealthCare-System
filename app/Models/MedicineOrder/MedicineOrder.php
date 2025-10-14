<?php

namespace App\Models\MedicineOrder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MedicineOrder\Mutators\MedicineOrderMutators;
use App\Models\MedicineOrder\Accessors\MedicineOrderAccessors;
use App\Models\MedicineOrder\Relations\MedicineOrderRelations;
use App\Models\MedicineOrder\Scopes\MedicineOrderScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\MedicineOrder\MedicineOrderObserver;

#[ObservedBy([MedicineOrderObserver::class])]
class MedicineOrder extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use MedicineOrderRelations;

    // Accessors & Mutators
    use MedicineOrderAccessors, MedicineOrderMutators;

    // Scopes
    use MedicineOrderScopes;

    protected $casts = [];

    protected $fillable = [
        'prescription_id', 
        'patient_id', 
        'pharmacy_id', 
        'status',
        'total_price', 
        'payment_status', 
        'payment_method'
    ];
}