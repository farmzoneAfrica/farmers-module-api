<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('farmer')->group(function () {
    Route::post('register', [\App\Http\Controllers\Auth\FarmerRegisterController::class, 'index']);
    Route::post('verify-otp', [\App\Http\Controllers\Auth\FarmerRegisterController::class, 'verifyOTP'])->middleware(['auth:sanctum', 'onboarding.access']);
    Route::get('resend-otp', [\App\Http\Controllers\Auth\FarmerRegisterController::class, 'resendOTP'])->middleware(['auth:sanctum', 'onboarding.access']);
    Route::post('change-phone', [\App\Http\Controllers\Auth\FarmerRegisterController::class, 'changePhoneNumber'])->middleware(['auth:sanctum', 'onboarding.access']);
    Route::post('kyc', [\App\Http\Controllers\Auth\FarmerRegisterController::class, 'kyc'])->middleware(['auth:sanctum', 'onboarding.access']);
});

Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.store');
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
