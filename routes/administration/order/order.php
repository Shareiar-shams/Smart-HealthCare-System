<?php

use App\Http\Controllers\Administration\Order\MedicineOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('/orders')->controller(MedicineOrderController::class)
    ->name('administration.orders.')
    ->group(function () {
        // Pharmacy selection for medicine order
        Route::get('/pharmacy/select/{prescription}', 'selectPharmacy')
            ->name('pharmacy.select')
            ->can('Medicine Order Create');

        // Create medicine order
        Route::post('/create/{prescription}', 'createOrder')
            ->name('create')
            ->can('Medicine Order Create');

        // Order confirmation
        Route::get('/confirmation/{order}', 'showConfirmation')
            ->name('confirmation')
            ->can('Medicine Order Read');

        // Order details
        Route::get('/show/{order}', 'show')
            ->name('show')
            ->can('Medicine Order Read');

        // Cancel order
        Route::post('/cancel/{order}', 'cancel')
            ->name('cancel')
            ->can('Medicine Order Update');

        // Update order status (for pharmacy/admin)
        Route::post('/update-status/{order}', 'updateStatus')
            ->name('update.status')
            ->can('Medicine Order Update');

        // Order history/index (for patients to see all their orders)
        Route::get('/my-orders', 'index')
            ->name('index')
            ->can('Medicine Order Read');
    });