<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Admin\BackpanelController;

// AUTHENTICATED
Route::middleware(['auth:api', 'email_verified', 'is_admin'])->group(function () {
    
    // Profile
    Route::post('/admin-backpanel', [BackpanelController::class, 'getInfos'])
        ->name('admin.backpanel');
});