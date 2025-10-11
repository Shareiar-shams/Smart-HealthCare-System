<?php

namespace App\Models\PrescriptionItem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PrescriptionItem\Mutators\PrescriptionItemMutators;
use App\Models\PrescriptionItem\Accessors\PrescriptionItemAccessors;
use App\Models\PrescriptionItem\Relations\PrescriptionItemRelations;
use App\Models\PrescriptionItem\Scopes\PrescriptionItemScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\PrescriptionItem\PrescriptionItemObserver;

#[ObservedBy([PrescriptionItemObserver::class])]
class PrescriptionItem extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use PrescriptionItemRelations;

    // Accessors & Mutators
    use PrescriptionItemAccessors, PrescriptionItemMutators;

    // Scopes
    use PrescriptionItemScopes;

    protected $casts = [];

    protected $fillable = ['prescription_id', 'medicine_name', 'dosage', 'duration', 'frequency'];
}