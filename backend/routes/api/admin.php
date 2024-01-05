<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BackpanelController;
use App\Http\Controllers\Admin\AppReleasesController;

// Public Accessible Data
Route::get('/get-app-release-details', [AppReleasesController::class, 'load'])
    ->name('get.app.release.details');

// AUTHENTICATED
Route::middleware(['auth:api', 'email_verified', 'is_admin'])->group(function () {
    
    // Dashboard
    Route::get('/admin-backpanel', [BackpanelController::class, 'getInfos'])
        ->name('admin.backpanel');

    // Releasemanagement
    Route::post('/create-app-release', [AppReleasesController::class, 'create'])
        ->name('create.app.release');
    Route::post('/update-app-release', [AppReleasesController::class, 'update'])
        ->name('update.app.release');
    Route::delete('/delete-app-release/{id}', [AppReleasesController::class, 'delete'])
        ->name('delete-app-release');
});
