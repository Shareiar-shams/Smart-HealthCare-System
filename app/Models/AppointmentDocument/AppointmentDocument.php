<?php

namespace App\Models\AppointmentDocument;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AppointmentDocument\Mutators\AppointmentDocumentMutators;
use App\Models\AppointmentDocument\Accessors\AppointmentDocumentAccessors;
use App\Models\AppointmentDocument\Relations\AppointmentDocumentRelations;
use App\Models\AppointmentDocument\Scopes\AppointmentDocumentScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\AppointmentDocument\AppointmentDocumentObserver;
use App\Traits\HasImage;

#[ObservedBy([AppointmentDocumentObserver::class])]
class AppointmentDocument extends Model
{
    use HasFactory, SoftDeletes, HasImage;

    // Relations
    use AppointmentDocumentRelations;

    // Accessors & Mutators
    use AppointmentDocumentAccessors, AppointmentDocumentMutators;

    // Scopes
    use AppointmentDocumentScopes;

    protected $casts = [];

    protected $fillable = [
        'appointment_id',
        'type',
        'file_path',
        'file_name',
    ];
}