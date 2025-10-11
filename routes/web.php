<?php

use App\Http\Controllers\ViewportController;
use Illuminate\Support\Facades\Route;


Route::controller(ViewportController::class)->group( function () {
    Route::get('/landing', 'landing')->name('landing');
    Route::get('/', 'index')->name('index');
});

//predictions routes
include 'viewport/prediction.php';
// Blood Donation Routes
include 'viewport/blooddonation.php';

// Medical Learning Routes - ADD THESE
include 'viewport/medicalLearning.php';

// Resources Routes
include 'viewport/resources.php';

Route::middleware(['auth', 'verified'])->group(function () {
    // administration dashboard
    include 'administration/dashboard/dashboard.php';
    include 'administration/appointment/appointment.php';
    include 'administration/prescription/prescription.php';
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
