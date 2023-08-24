<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerified
{
    public function handle(Request $request, Closure $next)
    {   
        try {
            $user = Auth::user();
            if(!$user) throw 'Unauthenticated! Please login again.';
            else if($user->email_verified_at) return $next($request);
            else $user->token()->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);  
        }

        // Email not verified
        return response()->json([
            'status' => 'email_not_verified',
            'email' => $user->email,
            'message' => 'Please verify your email before accessing your account.'
        ], 401);
    }
}
