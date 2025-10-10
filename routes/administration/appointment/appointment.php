<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('/appointment')->controller(AppointmentController::class)
    ->name('administration.appointment.')
    ->group(function () {
        Route::get('/my-appointments', 'myAppointments')->name('myAppointments')->can('Appointment Read');
        Route::get('/index', 'index')->name('index')->can('Appointment Read');
        Route::get('/create', 'create')->name('create')->can('Appointment Create');
        Route::post('/store', 'store')->name('store')->can('Appointment Create');
        Route::post('{id}/show', 'show')->name('show')->can('Appointment Read');
        Route::get('/{id}/edit', 'edit')->name('edit')->can('Appointment Update');
        Route::put('/{id}/update', 'update')->name('update')->can('Appointment Update');
        Route::delete('/{id}/delete', 'destroy')->name('destroy')->can('Appointment Delete');
    });