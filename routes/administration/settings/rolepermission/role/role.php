<?php

use App\Http\Controllers\Administration\Setting\Role\RoleController;
use Illuminate\Support\Facades\Route;


/* ==============================================
===============< Role Routes >==============
===============================================*/
Route::controller(RoleController::class)
        ->prefix('role')
        ->name('role.')
        ->group(function () {
            Route::get('/all', 'index')->name('index')->can('Role Read');
            Route::get('/create', 'create')->name('create')->can('Role Create');
            Route::post('/store', 'store')->name('store')->can('Role Create');
            Route::get('/show/{role}', 'show')->name('show')->can('Role Read');
            Route::get('/edit/{role}', 'edit')->name('edit')->can('Role Update');
            Route::post('/update/{role}', 'update')->name('update')->can('Role Update');
        });