<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/test-mail', function () {
    $details = [
        'title' => 'Test Email from Laravel',
        'body' => 'This is a test email using Mailtrap SMTP.'
    ];

    Mail::raw($details['body'], function ($message) use ($details) {
        $message->to('test@example.com')
                ->subject($details['title']);
    });

    return 'Email sent!';
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // administration dashboard
    include 'administration/dashboard/dashboard.php';
    include 'administration/appointment/appointment.php';
    Route::prefix('')
        ->name('administration.')
        ->group(function () {
            include 'administration/settings/settings.php';
        });
});

Route::middleware('auth')->group(function () {
    // user profile
    include 'profile/profile.php';
});

require __DIR__.'/auth.php';
