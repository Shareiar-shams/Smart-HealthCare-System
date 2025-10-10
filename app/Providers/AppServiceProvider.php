<?php

namespace App\Providers;

use App\Policies\RolePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\Administration\Settings\Role\RoleService::class, function ($app) {
            return new \App\Services\Administration\Settings\Role\RoleService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Manual Policy Registration Example:
        Gate::policy(
            Role::class,
            RolePolicy::class
        );
    }
}
