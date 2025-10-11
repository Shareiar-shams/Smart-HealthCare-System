<?php

use App\Http\Controllers\Administration\Prescription\PrescriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/prescription')->controller(PrescriptionController::class)
    ->name('administration.prescriptions.')
    ->group(function (){
        Route::get('/index', 'index')->name('index');
        Route::get('/create/{id}', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{appointment}/show', 'show')->name('show');
        Route::get('/{appointment}/edit', 'edit')->name('edit');
        Route::put('/{id}/update', 'update')->name('update');
        Route::delete('/{id}/delete', 'destroy')->name('delete');

        Route::get('/pdf/{appointment}', 'downloadPdf')->name('pdf');
});