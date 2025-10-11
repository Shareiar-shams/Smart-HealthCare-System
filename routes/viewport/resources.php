<?php

use App\Http\Controllers\Viewport\ResourcesController;
use Illuminate\Support\Facades\Route;

Route::controller(ResourcesController::class)->group(function (){
    Route::get('/resources', 'index')->name('resources');
    Route::get('/resource/{category}', 'showCategory')->name('resource.category');
    Route::get('/resources/youtube', 'youtube')->name('resources.youtube');
    Route::get('/resources', 'index')->name('resources');
    Route::get('/resources/youtube', 'youtube')->name('resources.youtube');

});