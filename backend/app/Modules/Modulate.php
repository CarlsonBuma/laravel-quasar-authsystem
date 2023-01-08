<?php

namespace App\Modules;

use Illuminate\Support\Facades\URL;

abstract class Modulate
{
    /**
     * Verification Links template
     *
     * @param String $route, url from application
     * @param Array $params, implents parameter to URL
     * @return String
     */
    static public function signedLink(String $route, Array $params = null): String
    {
        // BaseURL (SERVER)
        $assignedBaseURL = URL::to('/') . '/api';
        
        // External URL (APP)
        $appBaseURL = env('APP_URL');

        // Create Signed Laravel Route
        $signedVerificationLink = URL::temporarySignedRoute(
            $route,
            now()->addMinutes(10800),       // 1 Week
            $params, 
        );

        // Modulate VerificationLink for SPA URL (Client)
        // Replace $assignedBaseURL from $sigendVerificationLink by new $appBaseURL
        return str_replace($assignedBaseURL, $appBaseURL, $signedVerificationLink);
    }
}
