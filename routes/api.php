<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use App\Models\Classroom;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateClassroomRequest;

Route::get('/', function () {
    return ['ok' => true, 'message' => 'Welcome to the API'];
});

Route::prefix('api/v1')->group(function () {
    Route::get('login/{provider}/redirect', [AuthController::class, 'redirect'])->name('login.provider.redirect');
    Route::get('login/{provider}/callback', [AuthController::class, 'callback'])->name('login.provider.callback');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('forgot-password', [AuthController::class, 'sendResetPasswordLink'])->middleware('throttle:5,1')->name('password.email');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.store');
    Route::post('verification-notification', [AuthController::class, 'verificationNotification'])->middleware('throttle:verification-notification')->name('verification.send');
    Route::get('verify-email/{ulid}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::middleware(['auth:sanctum', 'verified'])->group(function () {

        Route::get('classrooms', [ClassroomController::class, 'index'])->name('classrooms');
        Route::post('classrooms', [ClassroomController::class, 'store'])->name('classrooms.store')->can('create', Classroom::class);
        Route::get('classrooms/{classroom}', [ClassroomController::class, 'show'])
            ->name('classrooms.show')
            ->middleware(ValidateClassroomRequest::class);
        Route::put('classrooms/{classroom}', [ClassroomController::class, 'update'])->name('classrooms.update');
        Route::delete('classrooms/{classroom}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');

    });

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('devices/disconnect', [AuthController::class, 'deviceDisconnect'])->name('devices.disconnect');
        Route::get('devices', [AuthController::class, 'devices'])->name('devices');
        Route::get('user', [AuthController::class, 'user'])->name('user');
        Route::post('account/update', [AccountController::class, 'update'])->name('account.update');
        Route::post('account/password', [AccountController::class, 'password'])->name('account.password');
        Route::middleware(['throttle:uploads'])->group(function () {
            Route::post('upload', [UploadController::class, 'image'])->name('upload.image');
        });


    });


});
