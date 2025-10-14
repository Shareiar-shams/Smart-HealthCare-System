<?php

namespace App\Models\Delivery\Relations;

use App\Models\MedicineOrder\MedicineOrder;

trait DeliveryRelations
{
    public function order()
    {
        return $this->belongsTo(MedicineOrder::class, 'order_id');
    }
}