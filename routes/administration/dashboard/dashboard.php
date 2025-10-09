<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {

    Route::get('/dashboard', 'index')->name('dashboard');

    // admin Activity Log
    Route::get('activities', 'activities')->name('activities.index');
});