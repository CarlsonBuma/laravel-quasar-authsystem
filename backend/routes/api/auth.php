<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Auth\RegisterController;
use App\Actions\Auth\UserAuthController;
use App\Actions\Auth\UserProfileController;
use App\Actions\Auth\PasswordResetController;
use App\Actions\Auth\TransferAccountController;
use App\Actions\Auth\EmailVerificationController;

/*
 * AUTH System - User Session
 *  > CSRF: "/sanctum/csrf-cookie"
 *  > Login
 *      > AUTH
 *      > Logout
 *  > Create Account
 *      > Verify Email
 *      > Request verify email 
 *  > Reset Password
 *      > Request reseting password
 *      > Reset Password
 *  > Verify new Email
 */
Route::post('/login', [UserAuthController::class, 'loginUser'])
    ->middleware(['throttle:6,1'])    
    ->name('login');

// Create Account
Route::post('/create-account', [RegisterController::class, 'register'])
    ->name('create.account');

// Email Verification
Route::post('/email-verification-request', [EmailVerificationController::class, 'emailVerificationRequest'])
    ->name('email.verification.request');
Route::get('/email-verification/{email}/{token}', [EmailVerificationController::class, 'emailVerification'])
    ->middleware(['throttle:6,1'])
    ->name('email.verification');

// Password Reset
Route::post('/password-reset-request', [PasswordResetController::class, 'passwordResetRequest'])
    ->name('password.reset.request');
Route::put('/password-reset/{email}/{token}', [PasswordResetController::class, 'passwordReset'])
    ->middleware(['throttle:6,1'])
    ->name('password.reset');

// Transfer Account
// Update Email, Set new Password, Verify Email
Route::put('/transfer-account/{email}/{token}/{transfer}', [TransferAccountController::class, 'transferAccount'])
    ->middleware(['throttle:6,1'])
    ->name('transfer.account');

/*
 * Auth by "Sanctum"
 * User - Account Management
 *  > change Avatar
 *  > change Name
 *  > change Password
 *  > > Change Email
 *      > Request changing email
 *      > Verify transfer
 *  > delete Account
 */
Route::middleware(['auth:api', 'email_verified'])->group(function () {

    // Auth
    Route::get('/auth', [UserAuthController::class, 'authUser'])
        ->name('auth');

    // Logout
    Route::post('/logout', [UserAuthController::class, 'logoutUser'])
        ->name('logout'); 
        
    // User Profile
    Route::post('/user-change-avatar', [UserProfileController::class, 'changeAvatar'])
        ->name('user.change.avatar');
    Route::post('/user-change-name', [UserProfileController::class, 'changeName'])
        ->name('user.change.name');
    Route::post('/user-change-password', [UserProfileController::class, 'changePassword'])
        ->name('user.change.password');
    
    // Transfer Account Request 
    // Email will be updated, after Emailverification, email_verified_at = null
    Route::post('/user-transfer-account', [TransferAccountController::class, 'accountTokenRequest'])
        ->name('user.transfer.account');
    
    // Delete User
    Route::post('/user-delete-account', [UserProfileController::class, 'deleteAccount'])
        ->name('user.delete.account');
});
