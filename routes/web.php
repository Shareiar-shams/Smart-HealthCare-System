<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(HomeController::class)->middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', 'index')->name('dashboard');

    // admin Activity Log
    Route::get('activities', 'activities')->name('activities.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Appointments (public listing, booking requires auth)
Route::get('doctors', [AppointmentController::class, 'index'])->name('appointments.doctors');
Route::get('doctors/{doctor}', [AppointmentController::class, 'show'])->name('appointments.doctor');
Route::post('doctors/{doctor}/book', [AppointmentController::class, 'store'])->name('appointments.book');
Route::get('my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my')->middleware('auth');

// Admin management routes (permissions, roles, user role assignment)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('roles', RoleController::class)->names('roles');

    Route::get('users/roles', [UserRoleController::class, 'index'])->name('users.roles');
    Route::put('users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');
});
require __DIR__.'/auth.php';
