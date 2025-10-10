<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // administration dashboard
    include 'administration/dashboard/dashboard.php';
    include 'administration/appointment/appointment.php';
    Route::prefix('')
        ->name('administration.')
        ->group(function () {
            include 'administration/settings/settings.php';
        });
});

Route::middleware('auth')->group(function () {
    // user profile
    include 'profile/profile.php';
});

require __DIR__.'/auth.php';
