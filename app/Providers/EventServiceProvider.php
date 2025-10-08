<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // parent::boot();

        Event::listen(Login::class, function ($event) {
            activity()
                ->causedBy($event->user)
                ->event('login')
                ->withProperties([
                    'url' => request()->fullUrl(),
                    'ip'  => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log(ucfirst($event->user->role->name).' logged in');
        });

        Event::listen(Logout::class, function ($event) {
            activity()
                ->causedBy($event->user)
                ->event('logout')
                ->withProperties([
                    'url' => request()->fullUrl(),
                    'ip'  => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log(ucfirst($event->user->role->name).' logged out');
        });
    }
}
