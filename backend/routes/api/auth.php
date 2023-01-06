<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Auth\UserAuthController;
use App\Actions\Auth\RegisterController;
use App\Actions\Auth\UserProfileController;
use App\Actions\Auth\EmailVerificationController;
use App\Actions\Auth\PasswordResetController;

/*
 * AUTH System
 *  > CSRF: "/sanctum/csrf-cookie"
 *  > Login
 *      > AUTH
 *      > Logout
 */
Route::post('/login', [UserAuthController::class, 'loginUser'])
    ->middleware(['throttle:6,1'])    
    ->name('login');

Route::get('/auth', [UserAuthController::class, 'authUser'])
    ->middleware(['auth:sanctum', 'email_verified'])
    ->name('auth');

Route::post('/logout', [UserAuthController::class, 'logoutUser'])
    ->middleware(['auth:sanctum', 'email_verified'])
    ->name('logout'); 

/*
 * Account Managemenr
 *  > create Account
 *  > verify Account
 *      > Request verify email 
 *      > Verify email
 *  > reset Password
 *      > Request reseting password
 *      > Reset Password
 */
Route::post('/create-account', [RegisterController::class, 'register'])
    ->name('create.account');

// Email verification
Route::post('/email-verification-request', [EmailVerificationController::class, 'emailVerificationRequest'])
    ->name('email.verification.request');
Route::get('/email-verification/{email}/{token}', [EmailVerificationController::class, 'confirmEmailLink'])
    ->middleware(['throttle:6,1'])
    ->name('email.verification');

// Password reset
Route::post('/password-reset-request', [PasswordResetController::class, 'sendPasswordResetLink'])
    ->name('password.reset.request');
Route::put('/password-reset/{email}/{token}', [PasswordResetController::class, 'resetPassword'])
    ->middleware(['throttle:6,1'])
    ->name('password.reset');

/*
 * User Account Management
 *  > change Avatar
 *  > change Name
 *  > change Password
 *  > > Change Email
 *      > Request changing email
 *      > Verify transfer
 *  > delete Account
 */

// Verify new email adress, with current account
Route::get('/user-transfer-verification/{email}/{token}/{transfer}', [EmailVerificationController::class, 'transferEmail'])
    ->middleware(['throttle:6,1'])
    ->name('user.transfer.verification');

// AUTHENTICATED
Route::middleware(['auth:sanctum', 'email_verified'])->group(function () {
    
    // Profile
    Route::post('/user-change-avatar', [UserProfileController::class, 'changeAvatar'])
        ->name('user.change.avatar');
    Route::post('/user-change-name', [UserProfileController::class, 'changeName'])
        ->name('user.change.name');
    Route::post('/user-change-password', [UserProfileController::class, 'changePassword'])
        ->name('user.change.password');
    
    // Email Transfer Request - Validate before updating new email
    Route::post('/user-transfer-request', [UserProfileController::class, 'emailTransferRequest'])
        ->name('user.transfer.request');
    
        // Delete User
    Route::post('/user-delete-account', [UserProfileController::class, 'deleteAccount'])
        ->name('user.delete.account');
});
