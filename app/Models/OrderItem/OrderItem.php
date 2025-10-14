<?php

namespace App\Models\OrderItem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderItem\Mutators\OrderItemMutators;
use App\Models\OrderItem\Accessors\OrderItemAccessors;
use App\Models\OrderItem\Relations\OrderItemRelations;
use App\Models\OrderItem\Scopes\OrderItemScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\OrderItem\OrderItemObserver;

#[ObservedBy([OrderItemObserver::class])]
class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use OrderItemRelations;

    // Accessors & Mutators
    use OrderItemAccessors, OrderItemMutators;

    // Scopes
    use OrderItemScopes;

    protected $casts = [];

    protected $fillable = [
        'order_id', 
        'medicine_name', 
        'dosage', 
        'quantity', 
        'price'
    ];
}