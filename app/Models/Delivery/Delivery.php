<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Delivery\Mutators\DeliveryMutators;
use App\Models\Delivery\Accessors\DeliveryAccessors;
use App\Models\Delivery\Relations\DeliveryRelations;
use App\Models\Delivery\Scopes\DeliveryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\Delivery\DeliveryObserver;

#[ObservedBy([DeliveryObserver::class])]
class Delivery extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use DeliveryRelations;

    // Accessors & Mutators
    use DeliveryAccessors, DeliveryMutators;

    // Scopes
    use DeliveryScopes;

    protected $casts = [];

    protected $fillable = [
        'order_id', 
        'delivery_address', 
        'contact_no', 
        'status', 
        'tracking_number', 
        'delivered_at'
    ];
}