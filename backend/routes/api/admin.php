<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Admin\BackpanelController;

// AUTHENTICATED
Route::middleware(['auth:sanctum', 'email_verified', 'is_admin'])->group(function () {
    
    // Profile
    Route::post('/admin-backpanel', [BackpanelController::class, 'getInfos'])
        ->name('admin.backpanel');
});
