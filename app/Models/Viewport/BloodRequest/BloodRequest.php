<?php

namespace App\Models\Viewport\BloodRequest;

use App\Models\Viewport\BloodRequest\Relations\BloodRequestRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    //Relationship
    use BloodRequestRelations;

    protected $fillable = [
        'patient_name', 'contact_person', 'phone', 'hospital',
        'blood_group', 'units_required', 'urgency', 'division',
        'district', 'required_date', 'gratitude_fee', 'additional_info', 'status'
    ];

}