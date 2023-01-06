<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerified
{
    public function handle(Request $request, Closure $next)
    {
        $errorCode = 403;
        
        try {
            $user = Auth::user();
            if($user && $user->email_verified_at) return $next($request);
            else if ($user) throw new Exception('Please verify your email.');
            
            // Error Handling
            $errorCode = 400;
            throw new Exception('Invalid data.');

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $errorCode);  
        }
    }
}
