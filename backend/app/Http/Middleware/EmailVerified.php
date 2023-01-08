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
        try {
            $user = Auth::user();
            if($user && $user->email_verified_at) return $next($request);
            throw new Exception('Please verify your email.');

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);  
        }
    }
}
