<?php

use App\Http\Controllers\Viewport\MedicalLearningController;
use Illuminate\Support\Facades\Route;

Route::controller(MedicalLearningController::class)->group(function (){
    Route::get('/medical-learning', 'index')->name('medical.learning');
    Route::get('/learning-module/{id}', 'showModule')->name('learning.module');
    Route::post('/complete-module', 'completeModule')->name('complete.module');

});