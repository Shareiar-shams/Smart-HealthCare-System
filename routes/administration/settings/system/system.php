<?php

use Illuminate\Support\Facades\Route;

Route::controller()->group(function () {
    // system settings
    Route::get('/', 'index')->name('index');
    Route::post('update', 'update')->name('update');
});