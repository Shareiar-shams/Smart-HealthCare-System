<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;

class PermissionModule extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['permissions'];
    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];


    /**
     * Get the permissions for the module.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'permission_module_id');
    }
}
