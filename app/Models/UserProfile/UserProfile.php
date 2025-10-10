<?php

namespace App\Models\UserProfile;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserProfile\Mutators\UserProfileMutators;
use App\Models\UserProfile\Accessors\UserProfileAccessors;
use App\Models\UserProfile\Relations\UserProfileRelations;
use App\Models\UserProfile\Scopes\UserProfileScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\Administration\UserProfile\UserProfileObserver;

#[ObservedBy([UserProfileObserver::class])]
class UserProfile extends Model
{
    use HasFactory, SoftDeletes;

    // Relations
    use UserProfileRelations;

    // Accessors & Mutators
    use UserProfileAccessors, UserProfileMutators;

    // Scopes
    use UserProfileScopes;

    protected $casts = [];

    protected $fillable = ['user_id', 'contact_no', 'address', 'city', 'state', 'country', 'postal_code', 'date_of_birth', 'gender', 'blood_group'];
}