<?php

use App\Http\Controllers\Administration\Setting\User\UserController;
use Illuminate\Support\Facades\Route;


/* ==============================================
===============< User Routes >==============
===============================================*/
Route::prefix('user')->name('user.')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/all', 'index')->name('index');

        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store')->can('User Create');
        Route::get('/edit/{user}', 'edit')->name('edit')->can('User Update');
        Route::post('/update/{user}', 'update')->name('update')->can('User Update');
        Route::get('/destroy/{user}', 'destroy')->name('destroy')->can('User Delete');

        Route::get('/show/{user}/profile', 'showProfile')->name('show.profile')->can('User Read');

        Route::put('/status/update/{user}', 'updateStatus')->name('status.update')->can('User Update');

    });

    Route::controller()->prefix('create/import')->name('import.')->group(function () {
        Route::get('/', 'index')->name('index')->can('User Create');
        Route::post('/upload', 'upload')->name('upload')->can('User Create');
    });
});
