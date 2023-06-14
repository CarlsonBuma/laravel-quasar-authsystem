<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BackpanelController;

// AUTHENTICATED
Route::middleware(['auth:api', 'email_verified', 'is_admin'])->group(function () {
    
    // Dashboard
    Route::get('/admin-backpanel', [BackpanelController::class, 'getInfos'])
        ->name('admin.backpanel');
});
