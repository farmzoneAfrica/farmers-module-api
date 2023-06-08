<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


/*Farmer's Onboarding*/
Route::prefix('farmer')->group(function () {
    /*Registration*/
    Route::post('register', [\App\Http\Controllers\Auth\Farmer\RegisterController::class, 'index']);
    Route::post('verify-otp', [\App\Http\Controllers\Auth\Farmer\RegisterController::class, 'verifyOTP'])->middleware(['auth:sanctum', 'onboarding.access']);
    Route::get('resend-otp', [\App\Http\Controllers\Auth\Farmer\RegisterController::class, 'resendOTP'])->middleware(['auth:sanctum', 'onboarding.access']);
    Route::post('change-phone', [\App\Http\Controllers\Auth\Farmer\RegisterController::class, 'changePhoneNumber'])->middleware(['auth:sanctum', 'onboarding.access']);
    Route::post('set-pin', [\App\Http\Controllers\Auth\Farmer\RegisterController::class, 'setPin'])->middleware(['auth:sanctum', 'onboarding.access']);

    //Route::post('kyc', [\App\Http\Controllers\Auth\Farmer\RegisterController::class, 'kyc'])->middleware(['auth:sanctum', 'onboarding.access']);
    //Route::post('enroll-face-id', [\App\Http\Controllers\Auth\Farmer\RegisterController::class, 'enrollFaceId'])->middleware(['auth:sanctum', 'onboarding.access']);

    /*Login*/
    Route::post('login', \App\Http\Controllers\Auth\Farmer\LoginController::class)->middleware('guest')->name('login');
    Route::post('verify-pin-code', \App\Http\Controllers\Auth\Farmer\VerifyLoginCodeController::class)->middleware(['auth:sanctum']);

    Route::post('forgot-pin', \App\Http\Controllers\Auth\Farmer\ForgotPinController::class)->middleware('guest')->name('forgot.pin');
    Route::post('verify-forgot-pin-otp', \App\Http\Controllers\Auth\Farmer\VerifyForgotPinOtpController::class)->middleware(['auth:sanctum', 'forgot.pin.access']);
    Route::get('resend-forgot-pin-otp', \App\Http\Controllers\Auth\Farmer\ResendResetPinOtpController::class)->middleware(['auth:sanctum', 'forgot.pin.access']);
    Route::put('reset-pin', \App\Http\Controllers\Auth\Farmer\ResetPinController::class)->middleware(['auth:sanctum', 'forgot.pin.access']);
    Route::get('logout', \App\Http\Controllers\Auth\Farmer\LogoutController::class)->middleware('auth:sanctum')->name('farmer.logout.pin');

    Route::get('login', function () {
        return response()->json(['message'=>'Unauthenticated'], 401);
    })->middleware('guest')->name('login.get');

});


Route::post('forgot-password-phone', \App\Http\Controllers\Auth\ForgotPasswordController::class)->middleware('guest')->name('forgot.password.phone');
Route::post('verify-forgot-password-code', \App\Http\Controllers\Auth\VerifyForgotPasswordCodeController::class)->middleware(['auth:sanctum', 'forgot.password.access']);
Route::put('reset-password', \App\Http\Controllers\Auth\ResetPasswordController::class)->middleware(['auth:sanctum', 'forgot.password.access']);




Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register');
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login');
Route::post('/forgot-password/email', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');
//Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.store');
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
