<?php

use App\Http\Controllers\Viewport\BloodDonationController;
use Illuminate\Support\Facades\Route;

Route::controller(BloodDonationController::class)->group(function (){
    Route::get('/blood-donation', 'index')->name('blood.donation');
    Route::post('/register-donor', 'registerDonor')->name('register.donor');
    Route::post('/request-blood', 'requestBlood')->name('request.blood');
    Route::post('/search-donors', 'searchDonors')->name('search.donors'); // Add this line
    Route::get('/donor-stats', 'getStats')->name('donor.stats');

});