<?php

namespace App\Models\Viewport\Donor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'blood_group', 
        'division', 'district', 'last_donation', 
        'health_conditions', 'availability', 'is_verified'
    ];

    // Remove the donations() relationship for now
    // We'll add it back when we create the Donation model

    public function isAvailable()
    {
        return $this->availability && $this->is_verified;
    }
}