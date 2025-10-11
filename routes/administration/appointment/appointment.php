<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('/appointment')->controller(AppointmentController::class)
    ->name('administration.appointment.')
    ->group(function () {
        Route::get('/my-appointments', 'myAppointments')->name('myAppointments')->can('Appointment Read');
        Route::get('/index', 'index')->name('index')->can('Appointment Read');
        Route::get('/all/patients/appointments', 'myPatientsAppointments')->name('myPatientsAppointments')->can('Appointment Read');
        Route::get('/doctor/appointments', 'doctorAppointments')->name('doctor.appointments')->can('Appointment Read');
        Route::get('/create', 'create')->name('create')->can('Appointment Create');
        Route::post('/store', 'store')->name('store')->can('Appointment Create');
        Route::get('{appointment}/show', 'show')->name('show')->can('Appointment Read');
        Route::get('/{appointment}/edit', 'edit')->name('edit')->can('Appointment Update');
        Route::put('/{appointment}/update', 'update')->name('update')->can('Appointment Update');
        Route::patch('/{id}/confirm', 'confirm')->name('confirm')->can('Appointment Update');
        Route::post('/{id}/reject', 'reject')->name('reject')->can('Appointment Update');
        Route::delete('/{appointment}/delete', 'destroy')->name('delete')->can('Appointment Delete');
    });
Route::prefix('/api')->controller(AppointmentController::class)
    ->group(function () {
        Route::get('/doctor/{doctor}/time-slots', 'getTimeSlots')->name('getTimeSlots')->can('Appointment Create');
    });