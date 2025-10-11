<?php

use App\Http\Controllers\Viewport\PredictionController;
use Illuminate\Support\Facades\Route;

Route::controller(PredictionController::class)->group(function () {
    Route::get('/predictions', 'index')->name('predictions');
    Route::post('/predict/heart-disease', 'predictHeartDisease')->name('predict.heart');
    Route::post('/predict/diabetes', 'predictDiabetes')->name('predict.diabetes');
    Route::post('/predict/liver', 'predictLiver')->name('predict.liver');
});