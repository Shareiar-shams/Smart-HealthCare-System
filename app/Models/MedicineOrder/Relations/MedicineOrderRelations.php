<?php

namespace App\Models\MedicineOrder\Relations;

use App\Models\Delivery\Delivery;
use App\Models\OrderItem\OrderItem;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Prescription\Prescription;
use App\Models\User;

trait MedicineOrderRelations
{
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'order_id');
    }
}