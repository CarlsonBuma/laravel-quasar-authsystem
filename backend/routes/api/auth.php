<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\UserAccountController;
use App\Http\Controllers\Auth\CreateAccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\TransferAccountController;
use App\Http\Controllers\Auth\EmailVerificationController;

/*
 * AUTH System - User Session
 *  > Create Account
 *      > Verify Email
 *      > Request verify email 
 *  > Reset Password
 *      > Request reseting password
 *      > Reset Password
 *  > Verify new Email
 */

// Create Account
Route::post('/create-account', [CreateAccountController::class, 'register'])
    ->name('create.account');

// Email Verification
Route::post('/email-verification-request', [EmailVerificationController::class, 'sendToken'])
    ->middleware(['throttle:5,1'])
    ->name('email.verification.request');
Route::put('/email-verification/{email}/{token}', [EmailVerificationController::class, 'verifyToken'])
    ->middleware(['throttle:5,1'])
    ->name('email.verification');

// Password Reset
Route::post('/password-reset-request', [PasswordResetController::class, 'sendToken'])
    ->middleware(['throttle:6,1'])
    ->name('password.reset.request');
Route::put('/password-reset/{email}/{token}', [PasswordResetController::class, 'verifyToken'])
    ->middleware(['throttle:6,1'])
    ->name('password.reset');

// Transfer Account
// Update Email, Set new Password, Verify Email
Route::put('/transfer-account/{email}/{token}/{transfer}', [TransferAccountController::class, 'verifyToken'])
    ->middleware(['throttle:6,1'])
    ->name('transfer.account');

/**
 ** Auth by "Laravel Passport"
 **  > Login
 **      > AUTH
 **      > Logout
 ** User - Account Management
 **  > change Avatar
 **  > change Name
 **  > change Password
 **     > Change Email
 **     > Request changing email
 **     > Verify transfer
 **  > delete Account
 */

Route::post('/login', [UserAuthController::class, 'loginUser'])
    ->middleware(['throttle:6,1'])    
    ->name('login');

Route::middleware(['auth:api', 'email_verified'])->group(function () {
    // Auth
    Route::get('/auth', [UserAuthController::class, 'authUser'])
        ->name('auth');

    // Logout
    Route::post('/logout', [UserAuthController::class, 'logoutUser'])
        ->name('logout'); 
        
    // User Account
    Route::post('/user-change-avatar', [UserAccountController::class, 'changeAvatar'])
        ->name('user.change.avatar');
    Route::post('/user-change-name', [UserAccountController::class, 'changeName'])
        ->name('user.change.name');
    Route::post('/user-change-password', [UserAccountController::class, 'changePassword'])
        ->name('user.change.password');
    
    // Transfer Account Request 
    // Email will be updated, after Emailverification, email_verified_at = null
    Route::post('/user-transfer-account', [TransferAccountController::class, 'sendToken'])
        ->name('user.transfer.account');
    
    // Delete User
    Route::post('/user-delete-account', [UserAccountController::class, 'deleteAccount'])
        ->name('user.delete.account');
});
