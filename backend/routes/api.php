<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// USER - ACOUNT Management
require __DIR__.'/api/auth.php';

// User Routes
Route::middleware(['auth:sanctum', 'email_verified'])->group(function () {

    // Implement User Routes
     
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});