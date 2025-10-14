<?php

namespace App\Models\OrderItem\Relations;

use App\Models\MedicineOrder\MedicineOrder;

trait OrderItemRelations
{
    public function order()
    {
        return $this->belongsTo(MedicineOrder::class, 'order_id');
    }
}