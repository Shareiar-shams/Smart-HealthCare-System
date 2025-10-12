<?php

use App\Http\Controllers\Administration\Prescription\PrescriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/prescription')->controller(PrescriptionController::class)
    ->name('administration.prescriptions.')
    ->group(function (){
        Route::get('/index', 'index')->name('index')->can('Prescription Read');
        Route::get('/create/{id}', 'create')->name('create')->can('Prescription Create');
        Route::post('/store', 'store')->name('store')->can('Prescription Create');
        Route::get('/{appointment}/show', 'show')->name('show')->can('Prescription Read');
        Route::get('/{appointment}/edit', 'edit')->name('edit')->can('Prescription Update');
        Route::put('/{id}/update', 'update')->name('update')->can('Prescription Update');
        Route::delete('/{id}/delete', 'destroy')->name('delete')->can('Prescription Delete');

        Route::get('/pdf/{appointment}', 'downloadPdf')->name('pdf');
});