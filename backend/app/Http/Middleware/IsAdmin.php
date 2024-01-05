<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {   
        try {
            $user = Auth::user();
            if(!$user) throw new Exception('Not verified.');
            else if($user->is_admin->user_id) return $next($request); 
            throw new Exception('Ups, no access to our backpanel.');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'no_admin',
                'message' => $e->getMessage(),
            ], 401);  
        }

        return response()->json([
            'message' => 'Ups, you are no admin.',
        ], 401);  
    }
}
